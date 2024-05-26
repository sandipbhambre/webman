<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("READ_ROLE");
        $flashData = collect([]);
        $query = Role::query();
        // SEARCH
        if ($request->has('search') && $request->search !== null) {
            $query->where(
                'name',
                'LIKE',
                '%' . $request->search . '%',
            );
            $flashData->push('search');
        }
        // SORT
        if ($request->has('sortBy') && $request->sortBy !== null) {
            $query->orderBy($request->sortBy);
            $flashData->push('sortBy');
        }
        // STATUS
        if ($request->has('status') && $request->status === 'active') {
            $query->active();
            $flashData->push('status');
        } else if ($request->has('status') && $request->status === 'inactive') {
            $query->inactive();
            $flashData->push('status');
        }
        $roleList = $query->paginate($request->numberOfRecords ? $request->numberOfRecords : 10)->withQueryString();
        $crudPermissions = Permission::where('is_crud', '=', true)->active()->get()->groupBy('model');
        $nonCrudPermissions = Permission::where('is_crud', '=', false)->active()->get()->groupBy('model');
        $request->flashOnly($flashData->toArray());
        return view("roles.index", ["roleList" => $roleList, "crudPermissions" => $crudPermissions, "nonCrudPermissions" => $nonCrudPermissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize("CREATE_ROLE");
        $request->validate([
            "name" => "required|string|unique:roles,id",
            "permissions" => "nullable",
            "permissions.*" => "nullable|exists:permissions,name",
        ]);
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => config('auth.defaults.guard')
        ]);
        $role->givePermissionTo($request->permissions);
        return response()->json([
            "status" => "success",
            "statusCode" => 201,
            "data" => [
                "role" => $role,
            ],
            "message" => "Role created successfully!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize("READ_ROLE");
        $permissions = $role->permissions()->pluck('name');
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "role" => $role,
                "permissions" => $permissions,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize("UPDATE_ROLE");
        $permissions = $role->permissions()->pluck('name');
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "role" => $role,
                "permissions" => $permissions,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize("UPDATE_ROLE");
        $request->validate([
            "name" => "required|string|unique:roles,id," . $role->id,
            "permissions" => "nullable",
            "permissions.*" => "nullable|exists:permissions,name",
        ]);
        $updatedRoleData = [];
        $updatedRoleData['name'] = $request->name;

        $role->update($updatedRoleData);
        $role->givePermissionTo($request->permissions);
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "role" => $role,
            ],
            "message" => "Role updated successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize("DELETE_ROLE");
        $role->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Current Record deleted successfully!"
        ], 200);
    }

    public function bulkUpdate(Request $request)
    {
        Gate::authorize("BULK_UPDATE_ROLE");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        $firstRecord = Role::where('id', $request->selectedItems[0])->first();
        $currentStatus = $firstRecord->is_active;
        Role::whereIn("id", $request->selectedItems)->update([
            "is_active" => !$currentStatus
        ]);
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => null,
            "message" => "Selected Records updated successfully!"
        ], 200);
    }

    public function bulkDestroy(Request $request)
    {
        Gate::authorize("BULK_DELETE_ROLE");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        Role::whereIn("id", $request->selectedItems)->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Selected Records deleted successfully!"
        ], 200);
    }
}
