@extends('layouts.app')

@section('page-title', __('Pre-Arrival'))

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('Pre-Arrival Management') }}</h3>
    <a href="{{ route('dashboard.pre-arrival.create') }}" class="btn btn-primary">{{ __('Create Pre-Arrival') }}</a>
</div>

@if(session('token'))
<div class="alert alert-info">
    <strong>{{ __('Pre-Arrival Link:') }}</strong><br>
    <code>{{ url('/pre-arrival/' . session('token')) }}</code>
</div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Full Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Arrival Date') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Link') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preArrivals as $preArrival)
            <tr>
                <td>{{ $preArrival->id }}</td>
                <td>{{ $preArrival->full_name }}</td>
                <td>{{ $preArrival->email }}</td>
                <td>{{ $preArrival->arrival_date->format('Y-m-d') }}</td>
                <td>
                    @if($preArrival->isUsed())
                        <span class="badge bg-secondary">{{ __('Used') }}</span>
                    @else
                        <span class="badge bg-success">{{ __('Active') }}</span>
                    @endif
                </td>
                <td>
                    <code>{{ url('/pre-arrival/' . $preArrival->token) }}</code>
                </td>
                <td>
                    <form method="POST" action="{{ route('dashboard.pre-arrival.destroy', $preArrival) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $preArrivals->links() }}
</div>
@endsection
