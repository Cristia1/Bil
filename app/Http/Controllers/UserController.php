<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Requests\ValidateUser;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $validator = app('App\Http\Requests\ValidateUser');
        $rules = $validator->rules();
        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = $user_id;
        $user = User::create($validatedData);

        return $this->userResponse($user, 200);
    }


    public function update(Request $request, User $user)
    {
        $validator = app('App\Http\Requests\ValidateUser');
        $rules = $validator->rules();
    
        $validatedData = $request->validate($rules);
        
        $user->upda te($validatedData);
        
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