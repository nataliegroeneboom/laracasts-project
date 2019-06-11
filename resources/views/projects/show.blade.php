@extends('layouts.app')

    @section('content')
    <header class="projects" >
    <div class="flex-header">
        <h2><a href="/projects">My Projects</a> / {{$project->title}}</h2>
        <button class='button'><a href="/projects/create">New Project</a></button> 
    </div>
    </header>
    <main>
        <div class="tasks-container">
            <div class="column-left">
                <div class="tasks">
                    <h2>Tasks</h2>
                    @foreach($project->tasks as $task)
                        <div class="card task-card">
                            <form method="POST" action="{{$project->path() . '/tasks/' . $task->id }}">
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
                    <textarea class="description card"> No utamur ullamcorper vix. Has perfecto suscipiantur in, nulla latine perfecto est an. Eos eu ullum audiam sententiae. Ius elitr dolor senserit ea, eu habeo veritus vel. Te eos rebum commune, est etiam deserunt necessitatibus te, vel aliquip efficiantur necessitatibus at. Ut diceret erroribus sed. Erat alterum eos an, mel diam zril similique et. Facer postulant suavitate vel ex. At quo accusata platonem. Eum id dico quaestio, at eos nobis civibus molestie.
                    </textarea>
                </div>
            </div>
            <div class="column-right">
                 @include('projects.card')
            </div>
        </div>    
    </main>
   
    @endsection