@extends('layouts.app')

    @section('content')
    <header class="projects" >
    <div class="flex-header">
    <h2><a href="/projects">My Projects</a> / {{$project->title}}</h2>
        <button class='button'><a href="{{$project->path() . '/edit'}}">Edit Project</a></button> 
    </div>
    </header>
    <main>
        <div class="tasks-container">
            <div class="column-left">
                <div class="tasks">
                    <h2>Tasks</h2>
                    @foreach($project->tasks as $task)
                        <div class="card task-card">
                            <form method="POST" action="{{$task->path()}}">
                                @method('PATCH')
                                @csrf 
                                <div class="flex">
                                <input value="{{$task->body}}" name="body" class="{{ $task->completed ? 'grey': ''}}">
                                    <input type="checkbox" name="completed" onChange="this.form.submit()"
                                    {{$task->completed ? 'checked' : ''}}
                                    /> 
                                </div>
                            </form>
                        </div>            
                    @endforeach
                    <div class="card task-card">
                        <form method="POST" action="{{$project->path() . '/tasks'}}">
                            @csrf                     
                            <input name="body" placeholder="Add new tasks" />
                         
                        </form>   
                     </div>  
                 </div>  
                <div class="tasks">
                    <h2>General Notes</h2>
                <form method="POST" action="{{$project->path()}}">
                    @method('PATCH')
                    @csrf
                        <textarea 
                        class="description card"
                        name="notes" 
                        placeholder="Any notes you want to add to your project"
                        > {{$project->notes}}
                        </textarea>
                        <button type="submit" class="button">Save</button>
                    </form>

                    @if($errors->any())  
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                @endif 
                    
                </div>
            </div>
            <div class="column-right">
                 @include('projects.card')
            </div>
        </div>    
    </main>
   
    @endsection