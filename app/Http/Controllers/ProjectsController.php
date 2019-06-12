<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        $projects = auth()->user()->projects()->orderBy('updated_at', 'desc')->get();
        return view('projects.index', compact('projects'));
       
    }

    public function create(){
        return view('projects.create');
    }

    public function store(){
 
        $project =  auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());

    }
    /**
     * show new project
     * @param \App\Project $project
     * 
     */

    public function show(Project $project){
        $this->authorize('update', $project);


        return view('projects.show', compact('project'));
    }

    public function update(Project $project){
        $this->authorize('update', $project);
        $attributes = $this->validateRequest();
        $project->update(request(['notes', 'title', 'description']));
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required', 
           'description' => 'required',
           'notes' => 'min:3' 
        ]);
    }
}
