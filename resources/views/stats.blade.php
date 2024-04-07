@extends('layouts.main')

@section('title', 'Stats')

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Stats for {{ $stats['redirect'][0]->url }}</h2>
            </div>
            <div class="card-body">
                <p class="card-text">Total Accesses: {{ $stats['totalAccesses'] }}</p>
                <p class="card-text">Total Unique Accesses: {{ $stats['uniqueAccesses'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Top Referrers</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($stats['topReferrers'] as $referrer)
                        <li class="list-group-item">{{ $referrer->referer }} ({{ $referrer->count }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Accesses in the Last 10 Days</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($stats['accessesLast10Days'] as $access)
                        <li class="list-group-item">Date: {{ $access->date }}, Total: {{ $access->total }}, Unique: {{ $access->unique }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>




@endsection
