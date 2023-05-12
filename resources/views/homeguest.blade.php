@extends('layouts.app')
@section('content')
    <div class="page_container">
        <div class="row">
            <?php $companies = \App\Models\savecompany::all(); ?>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Select category">Select Company:-</label>
                    <select name="company_id" id="company_id" class="form-control">
                        {{-- <option value="">Select company</option> --}}
                        @foreach ($companies as $comp)
                            @php
                                $premium = '';
                                if (true) {
                                    if ($loop->iteration > 3) {
                                        $premium = ' (Premium)';
                                    }
                                    $firstYear = $comp->stock_years->first();
                                    $otherYears = $comp->stock_years->slice(1);
                            @endphp
                                <option value="{{ $comp->id }}" 
                                    @if ($firstYear == $spanYear) selected="selected" @endif>
                                    {{ $comp->company_name }}
                                    @if ($firstYear == $spanYear) 
                                        @if ($premium) 
                                            <span class="premium-label">{{ $premium }}</span>
                                        @endif
                                    @endif
                                </option>
                            @php
                                    foreach ($otherYears as $year) {
                                        echo '<option value="" disabled>';
                                        echo $year;
                                        if ($premium) {
                                            echo ' (Premium)';
                                        }
                                        echo '</option>';
                                    }
                                }
                            @endphp
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="Select tag">Select Year-</label>
                    <select name="span_year" id="span_year" class="form-control select2" data-placeholder="Select the year"
                        style="width: 100%;">
                        {{-- Populate the stock years dropdown with the fetched stock years --}}
                        @foreach ($companies as $comp)
                            @if ($comp->user_type != 'a')
                                @php
                                    $firstYear = $comp->stock_years->first();
                                    $otherYears = $comp->stock_years->slice(1);
                                @endphp
                                <option value="{{ $firstYear }}" 
                                    @if ($firstYear == $spanYear) selected="selected" @endif>
                                    {{ $firstYear }}
                                    @if ($firstYear == $spanYear) 
                                        @if (count($otherYears) > 0)
                                            <span class="premium-label"> (Premium)</span>
                                        @endif
                                    @endif
                                </option>
                                @foreach ($otherYears as $year)
                                    <option value="{{ $year }}" disabled>
                                        {{ $year }} (Premium)
                                    </option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4" style="height:50%">
                <div class="form-group">
                    <label for="">&nbsp;</label> <!-- Empty label for spacing -->
                    <button type="submit" class="btn btn-success btn-block" id="searchbutton">Search</button>
                </div>
            </div>
        </div>
    </div>

    <center>
        <div style="width: 300px; height: 300px;">
            <canvas id="myChart"></canvas>
        </div>
    </center>

       <table id="company_share_table" class="table">
        <thead>
            <tr>
                <th>Company Id</th>
                <th>Company</th>
                <th>Shared Holder Id</th>
                <th>Shared Holder Name</th>
                <th>Percentage</th>
                <th>No. of Shares</th>
                <th>Reg Number</th>
                <th>Stock Year</th>
                <th>Stock Year Span</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body will be dynamically populated with the search results -->
        </tbody>
    </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            var companyId = $('#company_id').val(); // Get the initial value of the #company_id element

            if (companyId) {

                var spanYearSelect = $('#span_year');

                // Clear existing options
                spanYearSelect.empty();

                // Make AJAX request to fetch stock years for the selected company
                $.ajax({
                    url: '{{ route('getStockYears') }}',
                    type: 'GET',
                    data: {
                        'company_id': companyId
                    },
                    success: function(response) {
                        var stockYears = response.stockYears;

                        // Populate the years dropdown with the fetched stock years
                        stockYears.forEach(function(year) {
                            spanYearSelect.append($('<option>', {
                                value: year,
                                text: year
                            }));
                        });
                    },
                    error: function() {
                        // Handle error
                    }
                });
            }
        });

        $(document).on('change', '#company_id', function() {
            var companyId = $(this).val();
            var spanYearSelect = $('#span_year');

            // Clear existing options
            spanYearSelect.empty();

            // Make AJAX request to fetch stock years for the selected company
            $.ajax({
                url: '{{ route('getStockYears') }}',
                type: 'GET',
                data: {
                    'company_id': companyId
                },
                success: function(response) {
                    var stockYears = response.stockYears;

                    // Populate the years dropdown with the fetched stock years
                    stockYears.forEach(function(year) {
                        spanYearSelect.append($('<option>', {
                            value: year,
                            text: year
                        }));
                    });
                },
                error: function() {
                    // Handle error
                }
            });
        });

        $(document).on('click', '#searchbutton', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Get the selected values
            var companyID = $('#company_id').val();
            var spanYear = $('#span_year').val();

            // Make AJAX request to retrieve the company share data
            $.ajax({
                url: '{{ route('search') }}', // Use the dynamic URL from the form action
                type: 'GET',
                data: {
                    company_id: companyID,
                    span_year: spanYear
                },
                success: function(response) {
                    var companyShareData = response.companyShareData;
                    var tableBody = $('#company_share_table tbody');
                    var labels = [];
                    var dataValues = [];
                    companyShareData.forEach(function(data) {
                        labels.push(data.SharedCompanyname);
                        dataValues.push(data.Percentage);
                    });
                    console.log(labels);
                    console.log(dataValues);

                    tableBody.empty();
                    companyShareData.forEach(function(data) {
                        var row = $('<tr>');
                        row.append($('<td>').text(data.CompanyId));
                        row.append($('<td>').text(data.Company));
                        row.append($('<td>').text(data.SharedCompanyid));
                        row.append($('<td>').text(data.SharedCompanyname));
                        row.append($('<td>').text(data.Percentage));
                        row.append($('<td>').text(data.NoShares));
                        row.append($('<td>').text(data.Regnumber));
                        row.append($('<td>').text(data.StockYear));
                        row.append($('<td>').text(data.StockYearSpan));

                        tableBody.append(row);
                    });

                    // Destroy the existing chart
                    var existingChart = Chart.getChart('myChart');
                    if (existingChart) {
                        existingChart.destroy();
                    }

                    // Create and render the new chart
                    var dataset = {
                        label: 'Percentage',
                        data: dataValues,
                        borderWidth: 1
                    };
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [dataset]
                        },
                        options: {}
                    });
                },
                error: function() {
                    // Handle error
                }
            });
        });
    </script>
@endsection

