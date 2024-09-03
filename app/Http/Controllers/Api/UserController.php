<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\UserManagementTraits;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
     use UserManagementTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->getAllUsers();
            return response()->json(['users' => $users], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->createUser($validatedData);
            return response()->json(['success' => 'User created successfully'], 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'Unable to create user at this time. Please try again later.'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $this->updateUser($validatedData, $id);
            return response()->json(['success' => 'User updated successfully'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'Unable to update user at this time. Please try again later.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
            $this->deleteUser($id);
            return response()->json(['success' => 'User deleted successfully'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
