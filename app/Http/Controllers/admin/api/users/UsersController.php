<?php

namespace App\Http\Controllers\admin\api\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function listUser() {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    public function deleteUser($id) {
        $user = User::find($id);
        if(!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ]);
        }

        $check = $user->delete();
        if($check) {
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'User not deleted'
        ]);
    }
}
