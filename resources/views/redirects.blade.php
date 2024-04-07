@extends('layouts.main')

@section('title','Redirects')

@section('content')



<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>Data de Criação</th>
            <th>Último Acesso</th>
            <th>Data de Atualização</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($redirects as $redirect)
        <tr>
            <td>{{ $redirect->id }}</td>
            
            <td>{{ $redirect->url }}</td>
            <td>
                @if ($redirect->date_create)
                {{ \Carbon\Carbon::createFromTimestamp($redirect->date_create)->format('d/m/Y H:i:s') }}
                @endif
            </td>
            <td>
                @if ($redirect->last_access)
                {{ \Carbon\Carbon::createFromTimestamp($redirect->last_access)->format('d/m/Y H:i:s') }}
                @endif
            </td>
            <td>
                @if ($redirect->date_update)
                {{ \Carbon\Carbon::createFromTimestamp($redirect->date_update)->format('d/m/Y H:i:s') }}
                @endif
            </td>

            <td>
                <button type="button" class="btn  {{ $redirect->active == 1 ? 'btn-outline-success' : ' btn-outline-danger' }}" disabled> {{ $redirect->active == 1 ? 'Ativo' : 'Inativo' }}</button>
            </td>

            <td>
                <a href="{{ route('stats', $redirect->code) }}" class="btn btn-primary">Estatísticas</a>
                <a href="{{ route('logs', $redirect->code) }}" class="btn btn-info">Logs</a>
                <a href="{{ route('edit', $redirect->code) }}" class="btn btn-warning">Editar</a>
              


                <a href="{{ route('redirect', $redirect->code) }}" class="btn btn-outline-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                        <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                    </svg></a>

                <form action="{{ route('redirects.desactivate', $redirect->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    @if ($redirect->active)
                    <button type="submit" class="btn btn-danger">Desativar</button>
                    @else
                    <button type="submit" class="btn btn-success">Ativar</button>
                    @endif
                </form>

                <form action="{{ route('redirects.destroy', $redirect->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection