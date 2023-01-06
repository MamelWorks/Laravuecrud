<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    public function index($uuid)
    {
        $group = Group::where('uuid',$uuid)->first();
        $users = $group->users()->get();
        return response()->json($users);
    }
}
