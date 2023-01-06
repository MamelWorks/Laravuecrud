<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function index($uuid)
    {
        $user = User::where('uuid',$uuid)->first();
        $groups = $user->groups()->get();
        return response()->json($groups);
    }
    public function update($userUuid, $groupUuid)
    {
        $user = User::where('uuid',$userUuid)->first();
        $group = Group::where('uuid',$groupUuid)->first();
        $user->groups()->attach($group->id);
        return response()->json('The user '. $user->name .' has been added to a group  '. $group->name);
    }
    public function destroy($userUuid, $groupUuid)
    {
        $user = User::where('uuid',$userUuid)->first();
        $group = Group::where('uuid',$groupUuid)->first();
        $user->groups()->detach($group->id);
        return response()->json('The user '. $user->name .' has been removed from a group  '. $group->name);
    }
}
