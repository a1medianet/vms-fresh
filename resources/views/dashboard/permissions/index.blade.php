@extends('layouts.app')

@section('page-title', __('Permissions'))

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('Permissions Management') }}</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">{{ __('Create Permission') }}</button>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Display Name') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->display_name }}</td>
                <td>{{ $permission->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editPermission({{ $permission->id }})">{{ __('Edit') }}</button>
                    <form method="POST" action="{{ route('dashboard.permissions.destroy', $permission) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $permissions->links() }}
</div>

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dashboard.permissions.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create Permission') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Display Name') }}</label>
                        <input type="text" class="form-control" name="display_name" required>
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
