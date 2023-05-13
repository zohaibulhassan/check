@extends('layouts.app')
@section('content')
<style>
  #logoimage{
    border-radius: 40%;
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
  }
</style>
{{-- @dd($logo->logo) --}}
  <div class="page_container">
    <center>
      <div style=" padding: 10px; background-color: gray;">
        <img src="{{ asset('assets/images/' . $logo->logo) }}" id="logoimage" width="564px" height="370px"  alt="">
      </div>

      <form action="{{url('/savelogo')}}" method="post" enctype="multipart/form-data">
        @csrf
        <br>
        <input type="file" class="form-control"  value="Choose file" name="logofile">
        <br>
        <input class="form-control btn btn-secondary" type="submit" value="update">
        
      </form>
    </center>
    </div>
    
@endsection

