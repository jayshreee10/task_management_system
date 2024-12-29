<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function assignRoleToUser($userId, $role)
    {

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }


        if (!Role::where('name', $role)->exists()) {
            return response()->json(['message' => 'Invalid role provided.'], 400);
        }


        try {
            $user->assignRole($role);
            return response()->json(['message' => "Role '{$role}' assigned to user '{$user->name}' successfully."]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error assigning role: ' . $e->getMessage()], 500);
        }
    }
}
