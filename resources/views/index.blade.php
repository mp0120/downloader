<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Downloader</title>

        <link href="{{ URL::asset('font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('bootstrap-4.1.3-dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('bootstrap-4.1.3-dist/css/bootstrap.min.css') }}"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        @if ($errors->any())
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        
                        @if ( session('status', null) !== null )
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success">{{ session('status') }}</li>
                        </ul>
                        @endif
                        
                        <br>
                        
                        <form method="POST">
                            
                            @csrf
                            
                            <div class="form-group row">
                                <label for="url" class="col-sm-2 col-form-label">URL</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="url" name="url">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="method" class="col-sm-2 col-form-label">Download method</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="method" name="method">
                                        <option value="n">As new</option>
                                        <option value="r">Update the last existed with current URL</option>
                                        <option value="a">Update all resources with current URL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-check" style="text-align: center;">
                                <input class="form-check-input" type="checkbox" id="immediately" name="immediately">
                                <label for="immediately" class="form-check-label">Download immediately (not recommended for large resources)</label>
                            </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-primary btn-sm" id="Submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <table class="table table-light table-hover">
                    <thead>
                        <tr>
                            <th>Resource</th>
                            <th>Status</th>
                            <th>Download link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $resources as $resource )
                        <tr>
                            <td>{{ $resource->resource }}</td>
                            <td>{{ $resource->getStatus() }}</td>
                            <td>
                                <a href="{{ url('/download/' . $resource->id) }}"><i class="fa fa-download"></i> Download</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
