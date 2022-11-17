<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->toArray();
        return response()->json(array_reverse($users));
    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $user->save();
        return response()->json('User '. $user->name .' has been created!');
    }
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    public function update($id, Request $request)
    {
        $user = User::find($id);
        $requestArray = $request->all();
        $requestArray['password'] = empty($request->input('password')) ? $user->password : Hash::make($request->input('password'));
        $user->update($requestArray);

        return response()->json('User '. $user->name .' has been updated!');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->groups()->detach();
        $user->delete();
        return response()->json('User '. $user->name .' has been deleted!');
    }

}
