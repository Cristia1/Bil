<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Requests\ValidateUser;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(15);
        return response()->json($users);
    }


    public function store(Request $request)
    {
        $validator = app('App\Http\Requests\ValidateUser');
        $rules = $validator->rules();
        unset($rules['email']);

        $validatedData = $request->validate($rules);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        return response()->json($user, 201);
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = app('App\Http\Requests\ValidateUser');
        $rules = $validator->rules();

        unset($rules['email']);

        $validatedData = $request->validate($rules);
        // dd($user->toArray());
        // dd($rules);

        $user->update($validatedData);

        return $this->userResponse($user, 200);
    }




    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }


    public function UserProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();

        $user->update($data);

        return $this->userResponse($user, 200);
    }

    protected function userResponse(User $user, $statusCode)
    {
        return response()->json($user, $statusCode);
    }
}
