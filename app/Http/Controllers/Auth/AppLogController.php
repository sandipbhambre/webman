<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AppLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("READ_APP_LOG");
        $flashData = collect([]);
        $query = AppLog::query();
        // SEARCH
        if ($request->has('search') && $request->search !== null) {
            $query->where(
                'ip_address',
                'LIKE',
                '%' . $request->search . '%',
            )->orWhere(
                    'model',
                    'LIKE',
                    '%' . $request->search . '%',
                )->orWhere(
                    'operation',
                    'LIKE',
                    '%' . $request->search . '%',
                )->orWhere(
                    'username',
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
        $appLogList = $query->latest()->paginate($request->numberOfRecords ? $request->numberOfRecords : 10)->withQueryString();
        $request->flashOnly($flashData->toArray());
        return view("app-logs.index", ["appLogList" => $appLogList]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppLog $appLog)
    {
        Gate::authorize("READ_APP_LOG");
        return response()->json([
            "status" => "success",
            "statusCode" => 200,
            "data" => [
                "appLog" => $appLog,
            ],
            "message" => null,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppLog $appLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppLog $appLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppLog $appLog)
    {
        //
    }
}
