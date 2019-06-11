@extends('layouts.app')

    @section('content')
   <form method="POST" action="/projects">
    @csrf
    <h1>Create a Project</h1>
    <div class="form-group">
        <label for="description" class="label">Description</label>
        <div class="control">
            <input type="text" class="form-control" name="title" placeholder="title">
        </div>
    </div>
    <div class="form-group">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea class="form-control" name="description" placeholder="description"></textarea>
            </div>
        </div>
        <div class="form-group">

                <div class="control">
                    <button type="submit" class="button is-link">Create Project</button>
                    <div><a href="/projects">Cancel</a></div>
                </div>
            </div>
    </form> 
    @endsection
  
