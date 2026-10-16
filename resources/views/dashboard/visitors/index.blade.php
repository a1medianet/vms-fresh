@extends('layouts.app')

@section('page-title', __('Visitors'))

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('Visitors Management') }}</h3>
    <a href="{{ route('dashboard.visitors.create') }}" class="btn btn-primary">{{ __('Create Visitor') }}</a>
</div>

<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" class="form-control" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select class="form-select" name="status">
                <option value="">{{ __('All Statuses') }}</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                <option value="checked-in" {{ request('status') === 'checked-in' ? 'selected' : '' }}>{{ __('Checked In') }}</option>
                <option value="checked-out" {{ request('status') === 'checked-out' ? 'selected' : '' }}>{{ __('Checked Out') }}</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-secondary">{{ __('Filter') }}</button>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Full Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Nationality') }}</th>
                <th>{{ __('Arrival Date') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visitors as $visitor)
            <tr>
                <td>{{ $visitor->id }}</td>
                <td>{{ $visitor->full_name }}</td>
                <td>{{ $visitor->email }}</td>
                <td>{{ $visitor->nationality }}</td>
                <td>{{ $visitor->arrival_date->format('Y-m-d') }}</td>
                <td>
                    <span class="badge bg-{{ $visitor->status === 'checked-in' ? 'success' : ($visitor->status === 'checked-out' ? 'secondary' : 'warning') }}">
                        {{ $visitor->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('dashboard.visitors.show', $visitor) }}" class="btn btn-sm btn-info">{{ __('View') }}</a>
                    @if($visitor->status === 'pending')
                        <form method="POST" action="{{ route('dashboard.visitors.check-in', $visitor) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">{{ __('Check In') }}</button>
                        </form>
                    @endif
                    @if($visitor->status === 'checked-in')
                        <form method="POST" action="{{ route('dashboard.visitors.check-out', $visitor) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning">{{ __('Check Out') }}</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $visitors->links() }}
</div>
@endsection
