<?php

namespace App\Http\Controllers\Api;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function index()
    {
        return ProjectResource::collection(Project::paginate());
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $project = new Project();

        $project->name = $request->name;
        $project->description = $request->description;
        $project->status = $request->status;

        $project->save();

        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $project->update($request->only(['name', 'description', 'status']));

        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(null, 204);
    }

    private function validator($data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:planned,running,hold,finished,cancel',
        ]);
    }
}
