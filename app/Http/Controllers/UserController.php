<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::all()->toArray();
        return response()->json(array_reverse($users));
    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:users|min:5|max:20',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => ['required', 'confirmed', Password::min(8)]
        ]);
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $user->save();
        return response()->json('User '. $user->name .' has been created!');
    }
    public function show(string $uuid): \Illuminate\Http\JsonResponse
    {
        $user = User::where('uuid',$uuid)->firstOrFail();
        return response()->json($user);
    }
    public function update(string $uuid, Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('uuid',$uuid)->firstOrFail();
        $validated = $request->validate([
            'name' => ['required',Rule::unique('users')->ignore($user->id),'min:5','max:20'],
            'email' => ['required',Rule::unique('users')->ignore($user->id),'email:rfc,dns'],
            'password' => ['sometimes','nullable ','confirmed', Password::min(8)]
        ]);
        $requestArray = $request->all();
        $requestArray['password'] = empty($request->input('password')) ?
            $user->password : Hash::make($request->input('password'));
        $user->update($requestArray);

        return response()->json('User '. $user->name .' has been updated!');
    }
    public function destroy(string $uuid): \Illuminate\Http\JsonResponse
    {
        $user = User::where('uuid',$uuid)->firstOrFail();
        $user->groups()->detach();
        $user->delete();
        return response()->json('User '. $user->name .' has been deleted!');
    }

}
