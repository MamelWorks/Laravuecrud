<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class GroupController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $groups = Group::all()->toArray();
        return response()->json(array_reverse($groups));
    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:groups|min:3|max:20'
        ]);
        $group = new Group([
            'name' => $request->input('name')
        ]);

        $group->save();
        return response()->json('Group '. $group->name .' has been created!');
    }
    public function show(string $uuid): \Illuminate\Http\JsonResponse
    {
        $group = Group::where('uuid',$uuid)->firstOrFail();
        return response()->json($group);
    }
    public function update(string $uuid, Request $request): \Illuminate\Http\JsonResponse
    {
        $group = Group::where('uuid',$uuid)->firstOrFail();
        $validated = $request->validate([
            'name' => ['required',Rule::unique('groups')->ignore($group->id),'min:3','max:20']
        ]);
        $requestArray = $request->all();
        $group->update($requestArray);

        return response()->json('Group '. $group->name .' has been updated!');
    }
    public function destroy($uuid): \Illuminate\Http\JsonResponse
    {
        $group = Group::where('uuid',$uuid)->firstOrFail();
        $group->users()->detach();
        $group->delete();
        return response()->json('Group '. $group->name .' has been deleted!');
    }
}
