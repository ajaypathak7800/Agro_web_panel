@extends('layout')

@section('content')
<div class="container mt-3">
    <h2>CBBO Offline Data</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('cbbo_offline.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Import File</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>

    <a href="{{ route('cbbo_offline.export') }}" class="btn btn-success mt-3">Export</a>

    <h3 class="mt-5">CBBO Offline Data Table</h3>
    <div class="container">
    <div class="table-responsive" style="max-height: 500px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Is Active</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cbboOfflineData as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>
                        @if(is_array(json_decode($data->data)))
                            <pre>{{ json_encode(json_decode($data->data), JSON_PRETTY_PRINT) }}</pre>
                        @else
                            {{ $data->data }}
                        @endif
                    </td>
                    <td>{{ $data->image }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->updated_at }}</td>
                    <td>{{ $data->is_active }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
