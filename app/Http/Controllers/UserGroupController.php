<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        $groups = $user->groups()->get();
        return response()->json($groups);
    }
    public function update($userId, $groupId)
    {
        $user = User::find($userId);
        $group = Group::find($groupId);
        $user->groups()->attach($groupId);
        return response()->json('The user '. $user->name .' has been added to a group  '. $group->name);
    }
    public function destroy($userId, $groupId)
    {
        $user = User::find($userId);
        $group = Group::find($groupId);
        $user->groups()->detach($groupId);
        return response()->json('The user '. $user->name .' has been kicked from a group  '. $group->name);
    }
}
