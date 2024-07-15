@extends('layout')

@section('content')
<div class="container">
    <h2>User Action Activity</h2>
 

    <div class="table-responsive" style="max-height: 500px; overflow: auto;">
            <table id="multi-filter-select" class="display table table-striped table-hover">
                <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Activity Type</th>
                <th>Action Table</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->name }}</td>
                    <td>{{ $log->activity_type }}</td>
                    <td>{{ $log->action_table }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
  
</div>
@endsection
