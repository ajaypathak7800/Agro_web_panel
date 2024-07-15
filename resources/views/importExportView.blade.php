@extends('layout')

@section('page_title', 'CBBO Expert Import and Export')

@section('content')

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Import and Export Cbbo</h4>
                    <form action="{{ route('importCbbo') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                        @csrf
                        <input type="file" name="file" class="form-control d-inline" style="width: auto; display: inline;">
                        <button type="submit" class="btn btn-primary btn-round">Upload Excel</button>
                    </form>
                    <a href="{{ route('exportCbbo') }}" class="btn btn-success btn-round ms-auto">Export to Excel</a>
                </div>


                <div class="card-body">
        <div class="table-responsive" style="max-height: 550px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                          <thead>
                   <tr>
                                
                                    <th>IA Name</th>
                                    <th>CBBO Name</th>
                                    <th>CBBO Unique ID</th>
                                    <th>CBBO Expert Name</th>
                          
                                    <th>Designation</th>
                              
                               
                                    <th>State</th>
                                    <th>Block</th>
                                    <th>District</th>
                                   
                                </tr>
                                </thead>
             
                             
                            <tbody>
                                @foreach ($experts as $expert)
                                    <tr>
                                      
                                        <td>{{ $expert->ia_name }}</td>
                                        <td>{{ $expert->cbbo_name }}</td>
                                        <td>{{ $expert->cbbo_unique_id }}</td>
                                        <td>{{ $expert->cbbo_expert_name }}</td>
                                   
                                        <td>{{ $expert->designation }}</td>
                                     
                               
                                        <td>{{ $expert->state }}</td>
                                        <td>{{ $expert->block }}</td>
                                        <td>{{ $expert->district }}</td>
                                   
                                    </tr>
                                @endforeach
                 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


