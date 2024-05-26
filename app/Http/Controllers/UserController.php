<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("READ_USER");
        $flashData = collect([]);
        $query = User::query();
        // SEARCH
        if ($request->has('search') && $request->search !== null) {
            $query->where(
                'name',
                'LIKE',
                '%' . $request->search . '%',
            )->orWhere(
                    'username',
                    'LIKE',
                    '%' . $request->search . '%',
                )->orWhere(
                    'email',
                    'LIKE',
                    '%' . $request->search . '%',
                )->orWhere(
                    'mobile_number',
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
        $userList = $query->paginate($request->numberOfRecords ? $request->numberOfRecords : 10)->withQueryString();
        $roleList = Role::active()->get();
        $request->flashOnly($flashData->toArray());
        return view("users.index", ["userList" => $userList, "roleList" => $roleList]);
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
        Gate::authorize("CREATE_USER");
        $request->validate([
            "name" => "required|string",
            "gender" => "required|string|in:Male,Female",
            "email" => "required|email:rfc,dns",
            "username" => "required|string",
            "mobile_number" => "nullable|integer|digits:10",
            "password" => "required|string|min:8|max:15",
            "image" => "nullable|file|image|max:256|dimensions:ratio=1/1",
            "role" => "required|exists:roles,id"
        ]);
        $path = null;
        if ($request->hasFile("image")) {
            $name = $request->username . '.' . $request->file('image')->guessExtension();
            $path = $request->file('image')->storeAs('users', $name);
        }
        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'username' => $request->username,
            'mobile_number' => $request->mobile_number,
            'image' => $path,
            'password' => $request->password,
        ]);
        $role = Role::findOrFail($request->role);
        $user->assignRole([$role->name]);
        return response()->json([
            "status" => "success",
            "statusCode" => 201,
            "data" => [
                "user" => $user,
            ],
            "message" => "User created successfully!"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize("READ_USER");
        $user->getRoleNames();
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "user" => $user,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize("UPDATE_USER");
        $user->getRoleNames();
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "user" => $user,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize("UPDATE_USER");
        $request->validate([
            "name" => "required|string",
            "gender" => "required|string|in:Male,Female",
            "email" => "required|email:rfc,dns",
            "username" => "required|string",
            "mobile_number" => "nullable|integer|digits:10",
            "password" => "required|string|min:8|max:15",
            "image" => "nullable|file|image|max:256|dimensions:ratio=1/1",
            "role" => "required|exists:roles,id"
        ]);
        $path = null;
        if ($request->hasFile("image")) {
            $name = $request->username . '.' . $request->file('image')->guessExtension();
            $path = $request->file('image')->storeAs('users', $name);
        }
        $updatedUserData = [];
        $updatedUserData['name'] = $request->name;
        $updatedUserData['gender'] = $request->gender;
        $updatedUserData['email'] = $request->email;
        $updatedUserData['username'] = $request->username;
        $updatedUserData['mobile_number'] = $request->mobile_number;
        if ($path !== null) {
            $updatedUserData['image'] = $path;
        }
        if ($request->password !== '#OLD_PASSWORD') {
            $updatedUserData['password'] = $request->password;
        }

        $user->update($updatedUserData);
        $role = Role::findOrFail($request->role);
        $user->syncRoles([$role->name]);
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "user" => $user,
            ],
            "message" => "User updated successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize("DELETE_USER");
        $user->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Current Record deleted successfully!"
        ], 200);
    }

    public function bulkUpdate(Request $request)
    {
        Gate::authorize("BULK_UPDATE_USER");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        $firstRecord = User::where('id', $request->selectedItems[0])->first();
        $currentStatus = $firstRecord->is_active;
        User::whereIn("id", $request->selectedItems)->update([
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
        Gate::authorize("BULK_DELETE_USER");
        $request->validate(["selectedItems" => "list", "selectedItems.*" => "numeric"]);
        User::whereIn("id", $request->selectedItems)->delete();
        return response()->json([
            "status" => "success",
            "statusCode" => 204,
            "data" => null,
            "message" => "Selected Records deleted successfully!"
        ], 200);
    }
}
