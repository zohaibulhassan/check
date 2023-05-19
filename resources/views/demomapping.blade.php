@extends('layouts.app')

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
        <div class="page_container">
            <button id="createCompanyBtn" class="btn btn-success">Create Company</button>
            <center>

                <table class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Company Name</th>
                        <th>Description</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $company->company_name }}</td>
                            <td>{{ $company->company_description }}</td>
                            <td><a href="{{ url('demomap_company', $company->id) }}" class="btn btn-success">Map Company</a>
                            <a id="editCompanyBtn" class="btn btn-warning"
                                    href="{{ url('demoeditcompany', $company->id) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </center>
        </div>

        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Create Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBtn">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Registration form fields go here -->
                        <div class="col">

                            <form method="POST" name="contact-form" data-parsley-validate="" novalidate="" method="POST"
                                action="{{ route('demosavecompany') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Company Name"
                                        name="company_name" required>
                                </div>


                                <div class="form-group">
                                    <textarea class="form-control" rows="6" placeholder="Description" name="company_description" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">SUBMIT</button>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>




        <!-- Include jQuery library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Your JavaScript/jQuery code -->
        <script>
            $(document).ready(function() {
                $('#createCompanyBtn').click(function(e) {
                    e.preventDefault(); // Prevent the default link behavior

                    // Show the modal
                    $('#registerModal').modal('show');
                });

                $('#modalCloseBtn').click(function(e) {
                    // Hide the modal
                    $('#registerModal').modal('hide');
                });


            });
        </script>
    @endsection
