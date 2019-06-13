<div class="card">
        <ul>
           @foreach($project->activity as $activity)
               <li>
                   @include("projects.activity.{$activity->description}")
                <span class="grey">{{$activity->created_at->diffForHumans(null, true)}}</span>
               </li>
           @endforeach
        </ul>
       
    </div>