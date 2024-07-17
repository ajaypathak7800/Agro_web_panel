<!-- resources/views/admin/fpo_details.blade.php -->
@extends('layout')

@section('content')
    <h1>FPO Details</h1>
<div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                   
                            <form action="{{ route('importFpoDetails') }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="file" class="form-control d-inline" style="width: auto; display: inline;">
                                <button type="submit" class="btn btn-primary btn-round">Import FPO Details</button>
                            </form>


    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if (!empty($fpoDetails))
       
    <div class="table-responsive" style="max-height: 500px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fpoDetails as $fpo)
                    <tr>
                        <td>{{ $fpo->id }}</td>
                        <td>
                            @php
                                $data = json_decode($fpo->data, true);
                            @endphp
                            @if (is_array($data))
                                <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                {{ $fpo->data }}
                            @endif
                        </td>
                        <td>{{ $fpo->image }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No FPO details available.</p>
    @endif
@endsection
