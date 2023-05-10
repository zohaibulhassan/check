@extends('layouts.app')

@section('content')

@auth

@if(auth::user()->user_type == 'a')

<div class="page_container">
    <table class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Company Name</th>
                <th>Registration No</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @if($user->user_type == 'a')
            <tr>

                <td>{{ $loop->iteration }}</td>
                <td>(ME) {{ $user->company_name }}</td>
                <td class="text-warning">Admin</td>
            </tr>
            @continue
            @endif
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->company_name }}</td>
                <td>{{ $user->registration_no }}</td>
                <td><a href="{{url('map_company',$user->id)}}" class="btn btn-success">Map Company</a></td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endif
@endauth

@endsection