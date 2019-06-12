@extends('layouts.app')
    @section('content')
      <h1>Create a Project</h1>
        <form method="POST" action="/projects">
             @csrf
             @include('projects.form', 
             ['project' => new App\Project,
             'buttonText' => 'Create Project'])
         </form>    
    @endsection
  
