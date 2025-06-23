<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = 'Permission List';

        $permissions = Permission::when($request->search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('id','desc')->paginate(10)->appends($request->only('search'));

        $editPermission = $request->has('edit') ? Permission::findOrFail($request->edit) : null;

        return view('admin.permissions.index', compact('permissions', 'editPermission', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|array',
            'names.*' => 'required|string|max:255|unique:permissions,name',
        ]);
    
        foreach ($request->names as $name) {
            Permission::create(['name' => $name]);
        }
        return redirect()->route('admin.permissions.index')->with('success', 'Permission created.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name,' . $permission->id,
        ], [
            'name.required' => 'Permission name is required.',
            'name.unique'   => 'This permission already exists.',
        ]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted.');
    }
}
