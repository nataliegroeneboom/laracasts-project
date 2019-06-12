

 
    <div class="form-group">
        <label for="description" class="label">Title</label>
        <div class="control">
        <input 
            type="text" 
            class="form-control" 
            name="title" 
            placeholder="title" 
            value="{{$project->title}}"
            required>
        </div>
    </div>
    <div class="form-group">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea 
                    class="form-control" 
                    name="description" 
                    placeholder="description"
                    required>{{$project->description}}
                </textarea>
            </div>
        </div>
        <div class="form-group">

                <div class="control">
                    <button type="submit" class="button is-link">{{$buttonText}}</button>
                <div><a href="{{$project->path()}}">Cancel</a></div>
                </div>
            </div>
        <div class="form-group">
          @if($errors->any())  
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        @endif    
        </div>
 
