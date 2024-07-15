@extends('layout')

@section('content')

<div class="container mt-3">

    <h2>Import and Export Data</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('importagricultural') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Import File</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>

    <form action="{{ route('exportagricultural') }}" method="GET" class="mt-3">
        <button type="submit" class="btn btn-success">Export</button>
    </form>

    <h3 class="mt-5">Agricultural Data</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
            
                <!-- Add more headers as per your data structure -->
            </tr>
        </thead>
        <tbody>
            @foreach($agriculturalData as $data)
            <tr>
         
                <!-- Add more columns as per your data structure -->
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
