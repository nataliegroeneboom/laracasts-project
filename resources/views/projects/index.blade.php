
@extends('layouts.app')

    @section('content')
    <header class="projects" >
        <div class="flex-header">
                <h2>My Projects</h2>
               <button class='button'><a href="/projects/create">New Project</a></button> 
        </div>
    </header>
  
    <main class="projects-container">
        @forelse($projects as $project)
        <div class="flex-project">
           @include('projects.card')
        </div>
        @empty 
        <div>
            No Projects yet
        </div>
        @endforelse
    </main>
 
    @endsection
