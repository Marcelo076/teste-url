@extends('layouts.main')

@section('title', 'Edit Redirect')

@section('content')
    <div class="container">
        <h1>Editar Redirect</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('redirects.update', $redirect->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="url" class="form-label">URL de Destino:</label>
                <input type="text" id="url" name="url" class="form-control" value="{{ $redirect->url }}">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
