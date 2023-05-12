@extends('layouts.app')
{{-- @section('title', 'All Companies | YellowShare') --}}
@section('content')
<div class="page_container">
    @if (session('success'))
    <div class="alert alert-success">
        <center><i class="fa fa-check-circle" aria-hidden="true"></i> {{ session('success') }}</center>
    </div>
@endif
@if (session('failed'))
    <div class="alert alert-danger">
        <center><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ session('failed') }}
        </center>
    </div>
@endif
    <div class="col-sm-6">
        <h3>Edit Company</h3>
        <form  method="POST" name="contact-form" data-parsley-validate="" novalidate=""
        method="POST" action="{{ route('updatecompany') }}">
        @csrf
             <input type="hidden" name="id" value="{{$editcompanies->id}}">
            <div class="form-group">
            <input type="text" value="{{$editcompanies->company_name}}" class="form-control" placeholder="Company Name"  name="company_name" required>    
            </div>
          
            <div class="form-group">
              <textarea class="form-control"  rows="6" placeholder="Description" name="company_description" required>{{$editcompanies->company_description}}</textarea>
            </div> 
            <button type="submit" class="btn btn-success">SUBMIT</button>
        </form>

      </div>
</div>
@endsection