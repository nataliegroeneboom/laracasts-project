    <div class="card card-fixed">
        <a href="{{$project->path()}}"><h3>{{$project->title}}</h3></a>
            <div class="description">
                {{Str::limit($project->description, 100)}}
            </div>
    </div>