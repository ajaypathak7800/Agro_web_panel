@extends('layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Import and Export Users</h4>
                @if(session('success'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
                <form action="{{ route('importFPO') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" name="file" class="form-control d-inline" style="width: auto; display: inline;">
                    <button type="submit" class="btn btn-primary btn-round">Upload Excel</button>
                </form>
                <a href="{{ route('export') }}" class="btn btn-success btn-round ms-auto">Export to Excel</a>
            </div>

     
        <div class="table-responsive" style="max-height: 550px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Implementing Agency</th>
                                    <th>CBBO Name</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fpos as $fpo)
                                <tr>
                                    <td>{{ $fpo->id }}</td>
                                    <td>{{ $fpo->implementing_agency }}</td>
                                    <td>{{ $fpo->cbbo_name }}</td>
                                 
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
