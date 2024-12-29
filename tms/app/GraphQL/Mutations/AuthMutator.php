<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\GraphQL\Mutations\ValidationException;
use Illuminate\Auth\Events\Registered;

class AuthMutator
{

    public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];


        if (! $token = Auth::guard('api')->attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::guard('api')->user();

        return [
            'token' => $token,
            'user' => $user,
        ];
    }


    public function signup($root, array $args)
    {

        $validator = Validator::make($args, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);


        if ($validator->fails()) {

            throw new ValidationException('Validation failed', $validator->errors()->toArray());
        }


        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
        ]);


        event(new Registered($user));


        $token = JWTAuth::fromUser($user);

        return [
            'token' => $token,
            'user' => $user,
        ];
    }


    public function someMutationMethod($root, array $args)
    {

        if ($someConditionFails) {
            throw new ValidationException("Validation failed", [
                'field' => 'error message'
            ]);
        }
    }
}
