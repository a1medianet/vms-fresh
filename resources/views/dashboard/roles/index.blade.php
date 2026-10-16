@extends('layouts.app')

@section('page-title', __('Roles'))

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('Roles Management') }}</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">{{ __('Create Role') }}</button>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Display Name') }}</th>
                <th>{{ __('Permissions') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->display_name }}</td>
                <td>
                    @foreach($role->permissions as $permission)
                        <span class="badge bg-info">{{ $permission->display_name }}</span>
                    @endforeach
                </td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editRole({{ $role->id }})">{{ __('Edit') }}</button>
                    <form method="POST" action="{{ route('dashboard.roles.destroy', $role) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $roles->links() }}
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('dashboard.roles.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create Role') }}</h5>
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
                    <div class="mb-3">
                        <label class="form-label">{{ __('Permissions') }}</label>
                        @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}">
                            <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->display_name }}</label>
                        </div>
                        @endforeach
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
