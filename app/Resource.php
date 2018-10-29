<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Resource extends Model
{
    //
    const PENDING = 0;
    const DOWNLOADING = 1;
    const COMPLETE = 2;
    const ERROR = 3;
    
    public function getStatus() {
        switch ($this->status) {
            case self::PENDING:
                return 'PENDING';
            case self::DOWNLOADING:
                return 'DOWNLOADING';
            case self::COMPLETE:
                return 'COMPLETE';
            case self::ERROR:
                return 'ERROR';
        }
    }
    
    public function download() {
        return Storage::disk('ext_resources')->download($this->name);
    }
}
