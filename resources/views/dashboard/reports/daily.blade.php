@extends('layouts.app')

@section('page-title', __('Daily Report'))

@section('content')
<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="date" class="form-control" name="date" value="{{ request('date', now()->toDateString()) }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
        </div>
        <div class="col-md-2">
            <a href="?date={{ request('date', now()->toDateString()) }}&export=1&format=pdf" class="btn btn-danger">{{ __('Export PDF') }}</a>
        </div>
        <div class="col-md-2">
            <a href="?date={{ request('date', now()->toDateString()) }}&export=1&format=excel" class="btn btn-success">{{ __('Export Excel') }}</a>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-header">
        <h3>{{ __('Daily Report') }} - {{ $stats['date'] }}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Visitors Count') }}</h5>
                        <h2>{{ $stats['visitors_count'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Arrivals') }}</h5>
                        <h2>{{ $stats['arrivals'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Departures') }}</h5>
                        <h2>{{ $stats['departures'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ __('Occupancy Rate') }}</h5>
                        <h2>{{ $stats['occupancy_rate'] }}%</h2>
                    </div>
                </div>
            </div>
        </div>

        <h4>{{ __('Visitors') }}</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Full Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visitors as $visitor)
                    <tr>
                        <td>{{ $visitor->id }}</td>
                        <td>{{ $visitor->full_name }}</td>
                        <td>{{ $visitor->email }}</td>
                        <td>{{ $visitor->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
