<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;


class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all()->toArray();
        return response()->json(array_reverse($groups));
    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $group = new Group([
            'name' => $request->input('name')
        ]);

        $group->save();
        return response()->json('Group '. $group->name .' has been created!');
    }
    public function show($id)
    {
        $group = Group::find($id);
        return response()->json($group);
    }
    public function update($id, Request $request)
    {
        $group = Group::find($id);
        $requestArray = $request->all();
        $group->update($requestArray);

        return response()->json('Group '. $group->name .' has been updated!');
    }
    public function destroy($id)
    {
        $group = Group::find($id);
        $group->users()->detach();
        $group->delete();
        return response()->json('Group '. $group->name .' has been deleted!');
    }
}
