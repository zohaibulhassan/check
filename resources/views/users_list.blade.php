@extends('layouts.app')
@section('content')
<div class="page_container">

    <div class="page_container">
    <div id="success-alert" class="alert alert-success" style="display: none;">
        <center><i class="fa fa-check-circle" aria-hidden="true"></i> Your company is mapped, and the Excel sheet is downloaded on this system. Please upload the data.</center>
        <center><a href="{{ url('uploaddata') }}">Click here to upload</a></center>
    </div>

    
    
<table class="table table-striped table-bordered nowrap">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Name</th>
            <th>Email</th>
            {{-- <th>Registration No</th> --}}
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        @if($user->user_type == 'a')
            <tr>
                
                <td>{{ $loop->iteration }}</td>
                <td>(ME) {{ $user->company_name }}</td>
                {{-- <td>{{ $user->registration_no }}</td> --}}
                <td>
                @if($user->user_status == 'p')
                    <form action="{{ route('approve_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" >Approve</button>
                    </form>
                    <form action="{{ route('reject_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Reject</button>
                    </form>
                @elseif($user->user_status == 'a')
                    <a href="#" class="text-success">Approved</a>
                @else
                    <a href="#" class="text-danger">Reject</a>
                @endif
            </td>
            </tr>   
            @continue   
        @endif
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->company_name }}</td>
            <td>{{$user->email}}</td>
            {{-- <td>{{ $user->registration_no }}</td> --}}
            <td>
                @if($user->user_status == 'p')
                    <form action="{{ route('approve_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <form action="{{ route('reject_user', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                @elseif($user->user_status == 'a')
                    <a href="#" class="text-success">Approved</a>
                @else
                    <a href="#" class="text-danger">Reject</a>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

</table>
</div>









@endsection
