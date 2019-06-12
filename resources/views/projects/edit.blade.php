@extends('layouts.app')

    @section('content')
        <h1>Edit your  Project</h1>
        <form method="POST" action="{{$project->path()}}">
            @csrf
            @method('PATCH')
            @include('projects.form',
            ['buttonText' => 'Edit Project'])
        </form>
    @endsection