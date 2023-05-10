@extends('layouts.app')
@section('title', 'Upload Data | YellowShare')
@section('content')
<div class="page_container">
    <div class="col-md-12">
        <form id="upload-form" method="POST" action="{{url('/uploadDatafile')}}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="attachment">Upload Attachment:</label>
                <input type="file" name="attachment" id="attachment" accept=".xlsx, .xls">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
