<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait UserManagementTraits
{
    public function getAllUsers()
    {
        try {
            return User::all();
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to fetch users at this time. Please try again later.');
        }
    }

    public function getRoles()
    {
        try {
            return Role::pluck('name', 'name')->all();
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to fetch roles at this time. Please try again later.');
        }
    }

    public function createUser(array $data)
    {
        try {
            $data['password'] =Hash::make($data['password']);
            $user = User::create($data);
            $user->assignRole($data['role']);

            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to create user at this time. Please try again later.');
        }
    }

    public function getUserWithRoles(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $user->roles->pluck('name', 'name')->all();

            return [
                'user' => $user,
                'roles' => $roles,
                'userRole' => $userRole
            ];
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to retrieve user or roles at this time. Please try again later.');
        }
    }

    public function updateUser(array $data, string $id)
    {
        try {
            $user = User::findOrFail($id);
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                $data = Arr::except($data, ['password']);
            }

            $user->update($data);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($data['role']);

            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to update user at this time. Please try again later.');
        }
    }

    public function deleteUser(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return true;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception('Unable to delete user at this time. Please try again later.');
        }
    }


}