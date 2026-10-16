@extends('layouts.app')

@section('page-title', __('Visitor Details'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ __('Visitor Details') }}</h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">{{ __('Full Name') }}</dt>
            <dd class="col-sm-9">{{ $visitor->full_name }}</dd>

            <dt class="col-sm-3">{{ __('Email') }}</dt>
            <dd class="col-sm-9">{{ $visitor->email }}</dd>

            <dt class="col-sm-3">{{ __('Nationality') }}</dt>
            <dd class="col-sm-9">{{ $visitor->nationality }}</dd>

            <dt class="col-sm-3">{{ __('Passport Number') }}</dt>
            <dd class="col-sm-9">{{ $visitor->passport_number }}</dd>

            <dt class="col-sm-3">{{ __('Arrival Date') }}</dt>
            <dd class="col-sm-9">{{ $visitor->arrival_date->format('Y-m-d') }}</dd>

            <dt class="col-sm-3">{{ __('Departure Date') }}</dt>
            <dd class="col-sm-9">{{ $visitor->departure_date->format('Y-m-d') }}</dd>

            <dt class="col-sm-3">{{ __('Status') }}</dt>
            <dd class="col-sm-9">
                <span class="badge bg-{{ $visitor->status === 'checked-in' ? 'success' : ($visitor->status === 'checked-out' ? 'secondary' : 'warning') }}">
                    {{ $visitor->status }}
                </span>
            </dd>
        </dl>

        <h4 class="mt-4">{{ __('Assignments') }}</h4>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>{{ __('Room') }}</th>
                        <th>{{ __('Check In') }}</th>
                        <th>{{ __('Check Out') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visitor->assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->room->number }} ({{ $assignment->room->floor->building->name }})</td>
                        <td>{{ $assignment->check_in_at ? $assignment->check_in_at->format('Y-m-d H:i') : '-' }}</td>
                        <td>{{ $assignment->check_out_at ? $assignment->check_out_at->format('Y-m-d H:i') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('dashboard.visitors.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </div>
    </div>
</div>
@endsection
