@extends('layouts.app')

@section('page-title', __('Reports'))

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5>{{ __('Daily Reports') }}</h5>
                <a href="{{ route('dashboard.reports.daily') }}" class="btn btn-primary">{{ __('View') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5>{{ __('Weekly Reports') }}</h5>
                <a href="{{ route('dashboard.reports.weekly') }}" class="btn btn-primary">{{ __('View') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5>{{ __('Monthly Reports') }}</h5>
                <a href="{{ route('dashboard.reports.monthly') }}" class="btn btn-primary">{{ __('View') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5>{{ __('Yearly Reports') }}</h5>
                <a href="{{ route('dashboard.reports.yearly') }}" class="btn btn-primary">{{ __('View') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
