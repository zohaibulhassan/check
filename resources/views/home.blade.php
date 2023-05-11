@extends('layouts.app')
@section('content')

<div class="page_container">
   <form action="{{ route('search') }}" method="GET">
      <div class="row">
          
          <?php $companies = \App\Models\User::all();?>
          <div class="col-md-4">
              <div class="form-group">
                  <label for="Select category">Select Company:-</label>
                  <select name="company_id" id="company_id" class="form-control">
                      <option value="">Select company</option>
                      @foreach($companies as $comp)
                      @if ($comp->user_type != "a")
            <option value="{{$comp->id}}" @if($loop->first) selected @endif>{{$comp->company_name}}</option>

                      @endif
                      @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
               <div class="form-group">
                  <label for="Select tag">Select Year-</label>
                  <select name="span_year" id="span_year" class="form-control select2" data-placeholder="Select the year" style="width: 100%;">
                        
  
                </select>
               </div>
            </div>
         <div class="col-md-4" style="height:50%">
            <div class="form-group">
               <label for="">&nbsp;</label> <!-- Empty label for spacing -->
               <button type="submit" class="btn btn-success btn-block" id="property-filter">Search</button>
            </div>
         </div>
      </div>
   </form>
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

$(document).on('change', '#company_id', function() {
    var companyId = $(this).val();
    console.log(companyId);
    var spanYearSelect = $('#span_year');
    
    // Clear existing options
    spanYearSelect.empty();

    // Make AJAX request to fetch stock years for the selected company
    $.ajax({
        url: '{{ route("getStockYears") }}',
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

$(document).on('submit', 'form', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize(); // Serialize the form data

        // Make AJAX request to retrieve the company share data
        $.ajax({
            url: '{{ route("search") }}', // Use the dynamic URL from the form action
            type: 'GET',
            data: formData,
            success: function(response) {
                
                var companyShareData = response.companyShareData;
                var tableBody = $('#company_share_table tbody');

                // Clear existing table rows
                tableBody.empty();

                // Populate the table with the retrieved company share data
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

                // Update the chart with the new data
                updateChart(companyShareData);
            },
            error: function() {
                // Handle error
            }
        });
    });






</script>


<script>
    $(document).on('submit', 'form', function(event) {
    // event.preventDefault(); // Prevent the form from submitting normally
    
    var form = $(this);
    var url = form.attr('action');
    var formData = form.serialize(); // Serialize the form data
    
    // Make AJAX request to retrieve the company share data
    $.ajax({
        url: '{{ route("search") }}', // Use the dynamic URL from the form action
        type: 'GET',
        data: formData,
        success: function(response) {
            var companyShareData = response.companyShareData;
            
            // Extract the SharedCompanyName values from companyShareData
            var labels = companyShareData.map(function(data) {
                return data.SharedCompanyname;
            });
            
            // Generate data values without the "%" sign
            var dataValues = companyShareData.map(function(data) {
                // Remove the "%" sign from the percentage value
                var percentage = data.Percentage.replace('%', '');
                // Convert the value to a numeric format
                return parseFloat(percentage);
            });
            
            // Create the dataset object
            var dataset = {
                label: 'Percentage',
                data: dataValues,
                borderWidth: 1
            };
            
            // Create the chart
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [dataset]
                },
               options: {
  }
            });
  
            $(document).on('change', '#company_id', function() {
            var selectedValue = $(this).val();
            localStorage.setItem('selectedCompany', selectedValue);
        });

        $(document).on('change', '#span_year', function() {
            var selectedValue = $(this).val();
            localStorage.setItem('selectedYear', selectedValue);
        });

        // Reload the page
        function reloadPage() {
            // Retrieve the selected values from local storage
            var selectedCompany = localStorage.getItem('selectedCompany');
            var selectedYear = localStorage.getItem('selectedYear');

            // Set the selected values back in the dropdowns
            if (selectedCompany) {
                $('#company_id').val(selectedCompany);
            }

            if (selectedYear) {
                $('#span_year').val(selectedYear);
            }

            // Reload the page
            location.reload();
        }

        // Call the reloadPage function when the form is submitted
        $(document).on('submit', 'form', function(event) {
            event.preventDefault();
            reloadPage();
        });

        // Call the reloadPage function when the page loads
      
            
        },
        error: function() {
            // Handle error
        }
    });
});



</script>


@endsection