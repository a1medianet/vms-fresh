@extends('layouts.app')

@section('page-title', __('Housing'))

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('Buildings Management') }}</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBuildingModal">{{ __('Create Building') }}</button>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Floors') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buildings as $building)
            <tr>
                <td>{{ $building->id }}</td>
                <td>{{ $building->name }}</td>
                <td>{{ $building->address }}</td>
                <td>{{ $building->floors->count() }}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="viewBuilding({{ $building->id }})">{{ __('View') }}</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $buildings->links() }}
</div>

<!-- Create Building Modal -->
<div class="modal fade" id="createBuildingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dashboard.housing.buildings.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create Building') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Address') }}</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
