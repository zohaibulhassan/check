@extends('layouts.app')
@section('title', 'Map Companies | YellowShare')
@section('content')

    <div class="page_container">
        <div id="success-alert" class="alert alert-success" style="display: none;">
            <center><i class="fa fa-check-circle" aria-hidden="true"></i> Your company is mapped, and the Excel sheet is
                downloaded on this system. Please upload the data.</center>
            <center><a href="{{ url('demouploaddata') }}">Click here to upload</a></center>
        </div>

        <div class="col-md-12">
            <form id="download-form" method="POST" action="{{ url('demodownload') }}">

                @csrf

                <div class="col-md-6">
                    <input type="hidden" name="id" value="{{ request()->route('companyid') }}">
                    <div class="form-group">
                        <label for="Select category">Select Company:</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" data-placeholder="Select a company"
                                name="companies_id[]" style="width: 100%;">
                                {{-- <option value="">Select Companies</option> --}}
                                <option value="all">Select All</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Select tag">Select Year:</label>
                        <select name="years" id="tag_id" class="form-control select2"
                            data-placeholder="Select the year" style="width: 100%;">
                            @php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= $currentYear - 49; $i--) {
                                    $yearRange = $i;
                                    echo '<option value="' . $yearRange . '">' . $yearRange . '</option>';
                                }
                            @endphp
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Download Excel</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var downloadForm = document.getElementById('download-form');
            var successAlert = document.getElementById('success-alert');

            downloadForm.addEventListener('submit', function() {
                successAlert.style.display = 'block';
            });
        });

        $(document).ready(function() {
            $('.select2').select2();

            $('.select2').on('select2:select', function(e) {
                if (e.params.data.id === 'all') {
                    $(this).find('option').prop('selected', true);
                    $(this).trigger('change');
                }
            });

            $('.select2').on('select2:unselect', function(e) {
                if (e.params.data.id === 'all') {
                    $(this).find('option').prop('selected', false);
                    $(this).trigger('change');
                }
            });
        });
    </script>

@endsection
