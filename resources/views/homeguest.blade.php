@extends('layouts.app')
@section('content')
    <div class="page_container">
        <div class="row">
            <?php $companies = \App\Models\savecompany::all(); 
            $companies2 = \App\Models\demosavecompanies::all(); 
            ?>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Select category">Select Company:-</label>
                    <select name="company_id" id="company_id" class="form-control" style="width: 100%;">
                        {{-- <option value="">Select company</option> --}}
                       
                           

                             @foreach ($companies2 as $comp)
                                
                                 <option value="{{$comp->id}}"
                                    @if ($loop->iteration == 1) selected="selected" @endif> {{ $comp->company_name }}
                                </option>
                            @endforeach

                             @foreach ($companies as $comp)
                               <option value="" class="text-warning" id="premium" > {{ $comp->company_name }}
                                </option>
                            @endforeach
                     

                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="Select tag">Select Year-</label>
                    <select name="span_year" id="span_year" class=" form-select" data-placeholder="Select the year"
                        style="width: 100%;">
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
<div class="modal fade"  tabindex="-1" role="dialog">
  <div class="modal-dialog"  role="document">
    <div class="modal-content bg-dots-darker" class=""> 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBtn" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p> <img src="https://img.uxwing.com/wp-content/themes/uxwing/download/sport-awards/premium-icon.svg" width="70px" alt=""> Premium Feature Register to see more data</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" id="modalCloseBtn">Close</button>
        <a  class="btn btn-primary" href="{{url('register')}}" >Register</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




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
                    url: '{{ route('demogetStockYears') }}',
                    type: 'GET',
                    data: {
                        'company_id': companyId
                    },
                  
                    success: function(response) {
                        console.log(response);
                        var stockYears = response.stockYears;
                          
                        // Populate the years dropdown with the fetched stock years
                        stockYears.forEach(function(year) {
                            spanYearSelect.append($('<option >', {
                                value: year,
                                text: year
                            }));
                        }
                        
                        );
                    },
                    error: function() {
                        // Handle error
                    }
                });
            }
        });




        $(document).on('change', '#company_id', function() {
            var companyId = $(this).val();
           console.log(companyId);
            var spanYearSelect = $('#span_year');
            
            // Clear existing options
            spanYearSelect.empty();

            // Make AJAX request to fetch stock years for the selected company
            $.ajax({
                url: '{{ route('demogetStockYears') }}',
                type: 'GET',
                data: {
                    'company_id': companyId
                },
                success: function(response) {
                    var stockYears = response.stockYears;
                    console.log(stockYears);
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


        //Year fecting Ends


        $(document).on('click', '#searchbutton', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Get the selected values
            var companyID = $('#company_id').val();
            var spanYear = $('#span_year').val();

            // Make AJAX request to retrieve the company share data
            $.ajax({
                url: '{{ route('demosearch') }}', // Use the dynamic URL from the form action
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

    <script>
        setTimeout(() => {
            var companyID = $('#company_id').val();
            var spanYear = $('#span_year').val();

            // Make AJAX request to retrieve the company share data
            $.ajax({
                url: '{{ route('demosearch') }}', // Use the dynamic URL from the form action
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
        }, 1500);
    </script>
    <script>
        $('#company_id').change(function() {
      // Get the selected option's ID
  var selectedOptionId = $(this).children('option:selected').attr('id');

  if (selectedOptionId === 'premium') {
    console.log("hello");

    // Get the selected option's value
    var title = $(this).val();
    $('.modal-title').html(title);
    $('.modal').modal('show');
    
     $('.modal').click(function(e) {
                    // Hide the modal
                    $('.modal').modal('hide');
                });
  }
});
    </script>
@endsection
