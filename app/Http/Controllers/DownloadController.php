<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Resource;
use Illuminate\Support\Facades\Validator;

class DownloadController extends Controller
{
    // web
    public function showList() {
        return view('index', [
            'resources' => Resource::cursor()
        ]);
    }
    
    public function downloadFile($id = null) {
        if ( $id == null ) {
            return redirect('/');
        }
        return Resource::find($id)->download();
    }
    
    public function addToList(Request $request) {
        $request->validate([
            'url' => 'required|url|max:255',
            'method' => 'required'
        ]);
        
        if ( isset($request['immediately']) ) {
            $status = self::downloadNow($request->url, $request->method);
            return redirect('/')->with('status', 'downloaded');
        }
        
        self::addToSchedule($request->url, $request->method);
        
        return redirect('/')->with('status', 'added');
    }
    
    //API and features
    
    public function listOfResources() {
        $list = Resource::select('id', 'resource', 'status')->get()->toArray();
        $list = array_map(function ($resource) {
            $result = [
                'resource' => $resource['resource'],
                'link' => url('download/' . $resource['id'])
            ];
            switch ($resource['status']) {
                case Resource::PENDING:
                    $result['status'] = 'PENDING';
                    break;
                case Resource::DOWNLOADING:
                    $result['status'] = 'DOWNLOADING';
                    break;
                case Resource::ERROR:
                    $result['status'] = 'ERROR';
                    break;
                case Resource::COMPLETE:
                    $result['status'] = 'COMPLETE';
                    break;
            }
            return $result;
        }, $list);
        return response()->json($list, 200);
    }
    
    public function download(Request $request) {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:255',
            'flags' => 'array|nullable' //m: r - rewrite last, a - rewrite all, n or not exist - add as new, i: exist - run immediately, not exist run as soon as possible
        ]);
        
        if ( $validator->fails() ) {
            return response()->json($validator->errors(), 415);
        }
        
        $flags = isset($request['flags']) ? $request['flags'] : ['m' => 'n'];
        
        if ( isset($flags['i']) ) {
            $status = self::downloadNow($request->url, $flags['m'] ?? 'n');
            return response()->json(["Status" => 
                ($status != Resource::ERROR) ? 
                "Resource is downloaded" : "Resource not found"], 202);
        }
        
        self::addToSchedule($request->url, $flags['m'] ?? 'n');
        
        return response()->json(["Status" => "Resource added to queue"], 202);
    }
    
    public static function addToSchedule($url, $method) {
        switch ( $method ) {
            case 'n':
                $resource = new Resource();
                $resource->resource = $url;
                $resource->name = "";
                $resource->status = Resource::PENDING;
                $resource->save();
                break;
            case 'a':
                Resource::where([
                    ['resource', $url]
                ])->update([
                    'status' => Resource::PENDING
                ]);
                break;
            case 'r':
                $id = Resource::where([
                    ['status', Resource::COMPLETE],
                    ['resource', $url],
                ])->orWhere([
                    ['status', Resource::ERROR],
                    ['resource', $url],
                ])->max('id');
                
                Resource::where([
                    ['id', $id]
                ])->update([
                    'status' => Resource::PENDING
                ]);
        }
        return Resource::PENDING;
    }
    
    public static function downloadNow($url, $method) {
        switch ( $method ) {
            case 'n':
                return self::addNew($url);
                break;
            case 'a':
                return self::updateAll($url);
                break;
            case 'r':
                return self::updateLast($url);
                break;
        }
        
    }
    
    public static function addNew($url) {
        $resource = new Resource();
        $resource->resource = $url;
        $resource->status = Resource::PENDING;
        $resource->name = "";
        $resource->save();
        
        $file = file_get_contents($url);
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        
        if ( $file !== false ) {
            $resource->status = Resource::COMPLETE;
            $resource->name = self::generateFilename($ext);
            Storage::disk('ext_resources')->put($resource->name, $file);
            $resource->save();
        } else {
            $resource->status = Resource::ERROR;
            $resource->save();
        }
        
        return $resource->status;
    }
    
    public static function updateLast($url) {
        $id = Resource::where('resource', $url)->max('id');
        
        if ( $id == 0 ) {
            return self::addNew($url);
        }
        
        $resource = Resource::find($id);
        $resource->status = Resource::DOWNLOADING;
        $resource->save();

        $file = file_get_contents($url);
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        if ( $file !== false ) {
            $resource->status = Resource::COMPLETE;
            $resource->name = self::generateFilename($ext);
            Storage::disk('ext_resources')->put($resource->name, $file);
            $resource->save();
        } else {
            if ($resource->name != "") {
                Storage::disk('ext_resources')->delete($resource->name);
            }
            $resource->status = Resource::ERROR;
            $resource->save();
        }
        
        return $resource->status;
    }
    
    public static function updateAll($url) {
        Resource::where('resource', $url)->update([
            'status' => Resource::DOWNLOADING
        ]);

        $file = file_get_contents($url);
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        if ( $file !== false ) {
            foreach (Resource::where('resource', $url)->cursor() as $resource) {
                if ( $resource->name == "" ) {
                    $resource->name = self::generateFilename($ext);
                }
                $resource->status = Resource::COMPLETE;
                Storage::disk('ext_resources')->put($resource->name, $file);
                $resource->save();
            }
            return Resource::COMPLETE;
        }
        
        Resource::where('resource', $url)->update([
            'status' => Resource::DOWNLOADING
        ]);
        $arr = Resource::select('name')->where([
            ['resource', $url],
            ['name', '<>', '']
        ])->get();
        $arr = array_map(function ($value) {
            return $value->name;
        }, $arr);
        Storage::disk('ext_resources')->delete($arr);
        
        return Resource::ERROR;
    }
    
    public static function generateFilename( $ext ) {
        do {
            $name = str_random(200) . '.' . $ext;
        } while (in_array($name, Storage::disk('ext_resources')->files()));
        return $name;
    }
}
