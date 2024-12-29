<?php
namespace App\Http\Controllers\GraphQL;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class MutationController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            return [
                'message' => 'Login successful',
                'user' => $user
            ];
        } else {

            return [
                'message' => 'Invalid credentials',
                'user' => null
            ];
        }
    }
}
