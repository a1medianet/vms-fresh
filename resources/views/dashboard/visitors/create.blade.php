@extends('layouts.app')

@section('page-title', __('Create Visitor'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ __('Create Visitor') }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('dashboard.visitors.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Full Name') }}</label>
                <input type="text" class="form-control" name="full_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Nationality') }}</label>
                <input type="text" class="form-control" name="nationality" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Passport Number') }}</label>
                <input type="text" class="form-control" name="passport_number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Arrival Date') }}</label>
                <input type="date" class="form-control" name="arrival_date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Departure Date') }}</label>
                <input type="date" class="form-control" name="departure_date" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
            <a href="{{ route('dashboard.visitors.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
</div>
@endsection
