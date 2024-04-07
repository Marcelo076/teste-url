@extends('layouts.main')

@section('title','Log')

@section('content')

<div class="content-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID da Redirect</th>
                <th>IP</th>
                <th>User-Agent</th>
                <th>Referer</th>
                <th>Query Params</th>
                <th>Data e Hora do Acesso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($redirectLogs as $log)
            <tr>
                <td>{{ $log->redirect_id }}</td>
                <td>{{ $log->ip }}</td>
                <td>{{ $log->user_agent }}</td>
                <td>{{ $log->referer }}</td>
                <td>{{ $log->query_params }}</td>
                <td>{{ $log->accessed_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endsection