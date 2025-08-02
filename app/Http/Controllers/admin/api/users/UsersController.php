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

    public function getOneUser($id)
    {
        $user = User::with('role')->find($id);
        if(is_null($user)) {
            return response()->json('User not found', 404);
        }
        return response()->json([
            'user' => $user,
        ], 200);
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

    public function createUser(Request $request) {
        $data = $request->all();
        $data['password'] = bcrypt('12345678');
        $newUser = User::query()->create($data);
        if($newUser) {
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully'
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'User not created'
        ]);
    }

    public function updateUser(Request $request, $id) {
        $data = $request->all();
        $user = User::find($id);
        if(!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ]);
        }
        $check = $user->update($data);
        if($check) {
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully'
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'User not updated'
        ]);
    }
}
