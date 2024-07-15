@extends('layout')

@section('content')
<div class="container mt-3">
  
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                   
                            <form action="{{ route('importCbboUniqueIdMapping') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="file" class="form-control d-inline" style="width: auto; display: inline;">
                                <button type="submit" class="btn btn-primary btn-round">Upload Excel</button>
                            </form>
                            <a href="{{ route('exportCbboUniqueIdMapping') }}" class="btn btn-success btn-round ms-auto">Export to Excel</a>
                        </div>






                        <div class="table-responsive" style="max-height: 500px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
            <tr>
                <th>ID</th>
                <th>CBBO Name</th>
                <th>CBBO Unique ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cbbo_name }}</td>
                <td>{{ $item->cbbo_unique_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
