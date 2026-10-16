@extends('layouts.app')

@section('page-title', __('Dashboard'))

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('Total Visitors') }}</h5>
                <h2>{{ $stats['total_visitors'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('Pending') }}</h5>
                <h2>{{ $stats['pending_visitors'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('Checked In') }}</h5>
                <h2>{{ $stats['checked_in'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('Checked Out') }}</h5>
                <h2>{{ $stats['checked_out'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Recent Visitors') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentVisitors as $visitor)
                            <tr>
                                <td>{{ $visitor->full_name }}</td>
                                <td>{{ $visitor->email }}</td>
                                <td><span class="badge bg-{{ $visitor->status === 'checked-in' ? 'success' : ($visitor->status === 'checked-out' ? 'secondary' : 'warning') }}">{{ $visitor->status }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Active Pre-Arrivals') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Arrival Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPreArrivals as $preArrival)
                            <tr>
                                <td>{{ $preArrival->full_name }}</td>
                                <td>{{ $preArrival->email }}</td>
                                <td>{{ $preArrival->arrival_date->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
