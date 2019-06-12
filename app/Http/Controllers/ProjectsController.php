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
        //validate
       $attributes = request()->validate([
           'title' => 'required', 
           'description' => 'required',
           'notes' => 'min:3'      
           ]);

        //  $attributes['owner_id'] = auth()->id();
        $project =  auth()->user()->projects()->create($attributes);


        // Project::create($attributes);
        return redirect($project->path());

        return view('projects.index', compact('projects'));
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

        $project->update(request(['notes']));
        return redirect($project->path());
    }
}
