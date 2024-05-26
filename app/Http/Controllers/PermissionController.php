<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("READ_PERMISSION");
        $flashData = collect([]);
        $query = Permission::query();
        // SEARCH
        if ($request->has('search') && $request->search !== null) {
            $query->where(
                'name',
                'LIKE',
                '%' . $request->search . '%',
            )->orWhere(
                    'operation',
                    'LIKE',
                    '%' . $request->search . '%',
                )->orWhere(
                    'model',
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
        $permissionList = $query->paginate($request->numberOfRecords ? $request->numberOfRecords : 10)->withQueryString();
        $request->flashOnly($flashData->toArray());
        return view("permissions.index", ["permissionList" => $permissionList]);
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
        Gate::authorize("CREATE_PERMISSION");
        $request->validate([
            "name" => "required|string",
            "operation" => "required|string",
            "model" => "required|string",
            "is_crud" => "required|string|in:Yes,No",
        ]);
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => config('auth.defaults.guard'),
            'operation' => $request->operation,
            'model' => $request->model,
            'is_crud' => $request->is_crud === 'Yes' ? true : false,
        ]);
        return response()->json([
            "status" => "success",
            "statusCode" => 201,
            "data" => [
                "permission" => $permission,
            ],
            "message" => "Permission created successfully!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        Gate::authorize("READ_PERMISSION");
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "permission" => $permission,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        Gate::authorize("UPDATE_PERMISSION");
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "permission" => $permission,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        Gate::authorize("UPDATE_PERMISSION");
        $request->validate([
            "name" => "required|string",
            "operation" => "required|string",
            "model" => "required|string",
            "is_crud" => "required|string|in:Yes,No",
        ]);
        $updatedPermissionData = [];
        $updatedPermissionData['name'] = $request->name;
        $updatedPermissionData['operation'] = $request->operation;
        $updatedPermissionData['model'] = $request->model;
        $updatedPermissionData['is_crud'] = $request->is_crud === 'Yes' ? true : false;

        $permission->update($updatedPermissionData);
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "permission" => $permission,
            ],
            "message" => "Permission updated successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        Gate::authorize("DELETE_PERMISSION");
        $permission->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Current Record deleted successfully!"
        ], 200);
    }

    public function bulkUpdate(Request $request)
    {
        Gate::authorize("BULK_UPDATE_PERMISSION");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        $firstRecord = Permission::where('id', $request->selectedItems[0])->first();
        $currentStatus = $firstRecord->is_active;
        Permission::whereIn("id", $request->selectedItems)->update([
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
        Gate::authorize("BULK_DELETE_PERMISSION");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        Permission::whereIn("id", $request->selectedItems)->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Selected Records deleted successfully!"
        ], 200);
    }
}
