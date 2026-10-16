<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(15);
        return view('dashboard.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'display_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Permission::create($validated);

        return redirect()->route('dashboard.permissions.index')
            ->with('success', __('Permission created successfully'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $permission->update($validated);

        return redirect()->route('dashboard.permissions.index')
            ->with('success', __('Permission updated successfully'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('dashboard.permissions.index')
            ->with('success', __('Permission deleted successfully'));
    }
}
