@extends('layout')

@section('page_title', 'Customer Import and Export')

@section('content')
 
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Import and Export Users</h4>
                            <form action="{{ route('importexcel') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="file" class="form-control d-inline" style="width: auto; display: inline;">
                                <button type="submit" class="btn btn-primary btn-round">Upload Excel</button>
                            </form>
                            <a href="{{ route('export-users') }}" class="btn btn-success btn-round ms-auto">Export to Excel</a>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                      
                            <div class="table-responsive" style="max-height: 500px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
                         
                                    
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                        
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                           
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                     
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
    </div>
@endsection

@push('scripts')
 
@endpush
