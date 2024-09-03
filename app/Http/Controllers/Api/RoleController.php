<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\RoleManagementTraits;
use App\Traits\UserManagementTraits;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleController extends Controller
{
    use RoleManagementTraits ,UserManagementTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json(['roles' => $roles], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'Unable to retrieve roles at this time. Please try again later.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        try {
            $roleData = $request->validated();
            $this->createRole($roleData);
            return response()->json(['success' => 'Role created successfully'], 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'Unable to create role at this time. Please try again later.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = $this->showRole($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'Unable to retrieve role details at this time. Please try again later.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, string $id)
    {
        try {
            $roleData = $request->validated();
            $this->updateRole($roleData, $id);
            return response()->json(['success' => 'Role updated successfully'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'Unable to update role at this time. Please try again later.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
            $this->deleteRole($id);
            return response()->json(['success' => 'Role deleted successfully'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
