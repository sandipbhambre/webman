<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("READ_MENU");
        $flashData = collect([]);
        $query = Menu::query();
        // SEARCH
        if ($request->has('search') && $request->search !== null) {
            $query->where(
                'title',
                'LIKE',
                '%' . $request->search . '%',
            )->orWhere(
                    'sub_title',
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
        $menuList = $query->paginate($request->numberOfRecords ? $request->numberOfRecords : 10)->withQueryString();
        $request->flashOnly($flashData->toArray());
        return view("menus.index", ["menuList" => $menuList]);
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
        Gate::authorize("CREATE_MENU");
        $request->validate([
            "title" => "required|string",
            "sub_title" => "nullable|string",
            "icon" => "required|string",
            "sub_icon" => "nullable|string",
            "order" => "required|integer",
            "sub_order" => "nullable|integer",
            "route" => "required|string",
            "permissions" => "nullable|string",
        ]);
        $menu = Menu::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'icon' => $request->icon,
            'sub_icon' => $request->sub_icon,
            'order' => $request->order,
            'sub_order' => $request->sub_order,
            'route' => $request->route,
            'permissions' => $request->permissions,
        ]);
        return response()->json([
            "status" => "success",
            "statusCode" => 201,
            "data" => [
                "menu" => $menu,
            ],
            "message" => "Menu created successfully!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        Gate::authorize("READ_MENU");
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "menu" => $menu,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        Gate::authorize("UPDATE_MENU");
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "menu" => $menu,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        Gate::authorize("UPDATE_MENU");
        $request->validate([
            "title" => "required|string",
            "sub_title" => "nullable|string",
            "icon" => "required|string",
            "sub_icon" => "nullable|string",
            "order" => "required|integer",
            "sub_order" => "nullable|integer",
            "route" => "required|string",
            "permissions" => "nullable|string",
        ]);
        $updatedMenuData = [];
        $updatedMenuData['title'] = $request->title;
        $updatedMenuData['sub_title'] = $request->sub_title;
        $updatedMenuData['icon'] = $request->icon;
        $updatedMenuData['sub_icon'] = $request->sub_icon;
        $updatedMenuData['order'] = $request->order;
        $updatedMenuData['sub_order'] = $request->sub_order;
        $updatedMenuData['route'] = $request->route;
        $updatedMenuData['permissions'] = $request->permissions;

        $menu->update($updatedMenuData);
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "menu" => $menu,
            ],
            "message" => "Menu updated successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Gate::authorize("DELETE_MENU");
        $menu->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Current Record deleted successfully!"
        ], 200);
    }

    public function bulkUpdate(Request $request)
    {
        Gate::authorize("BULK_UPDATE_MENU");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        $firstRecord = Menu::where('id', $request->selectedItems[0])->first();
        $currentStatus = $firstRecord->is_active;
        Menu::whereIn("id", $request->selectedItems)->update([
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
        Gate::authorize("BULK_DELETE_MENU");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        Menu::whereIn("id", $request->selectedItems)->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Selected Records deleted successfully!"
        ], 200);
    }
}
