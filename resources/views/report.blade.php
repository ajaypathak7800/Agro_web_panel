@extends('layout')

@section('page_title', 'Dashboard')

@section('content')
<style>
    .custom-width-select {
      width: 282px;
      font-size: 1.5rem; /* Increase font size */
    }
    .form-label {
      font-size: 1.5rem; /* Increase font size of label */
    }
   
</style>


<div class="container mt-3">
  <h2>Report</h2>
  <form id="apiForm" class="row">
    <div class="col-auto">
      <label for="apiEndpoint" class="form-label me-2 mb-0"></label>
      <select class="form-select custom-width-select me-2" id="apiEndpoint" name="apiEndpoint">
        <option value="">Select Report</option>
        <option value="newhasConnectivity">New Has Connectivity</option>
        <option value="newselectedGstReturn">New Selected GST Return</option>
        <option value="newfromInputBusiness">New From Input Business</option>
        <option value="awarenessProgram">Awareness Program</option>
        <option value="newkharifCrops">New Kharif Crops</option>
      </select>
    </div>

    <div class="col-auto">
      <br>
      <button type="submit" class="btn btn-primary">Generate Report</button>
    </div>
    <div class="col-12 mt-3">
      <div id="successMessage" class="alert alert-success d-none" role="alert">
        Report generated in a few seconds!
      </div>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
$(document).ready(function() {
    $('#apiForm').on('submit', function(e) {
        e.preventDefault();
        var selectedApi = $('#apiEndpoint').val();
        var searchData = $('#searchInput').val();

        // Construct the API URL based on selectedApi and searchData
        var apiUrl = '{{ url("api/") }}' + '/' + selectedApi + '';

        // Add search query parameter if searchData is not empty
        if (searchData) {
            apiUrl += '?search=' + encodeURIComponent(searchData);
        }
                              
        // Redirect to the API endpoint for downloading Excel
        window.location.href = apiUrl;
                    
        // Show success message

        $('#successMessage').removeClass('d-none');
                             
        //  Hide success message after 3 seconds
        setTimeout(function() {
            $('#successMessage').addClass('d-none');
        }, 3000);
    });
});
</script>
@endsection

