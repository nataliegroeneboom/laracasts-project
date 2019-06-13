<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

    public function path(){
        return "/projects/{$this->id}";
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
    public function addTask($body){
      return $this->tasks()->create(compact('body'));
    }

    public function activity(){
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * Record activity for a project
     * 
     * @param string $description
     */
    public function recordActivity($description)
    {
        // project id is assigned automatically
     
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) == 'Project' ?$this->id : $this->project_id,
        ]);
    }

    protected function activityChanges()
    {
        // wasChanged is an Eloquent method
        //getChanges is also an eloquent method provided
        if($this->wasChanged()){
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()),'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at')
            ];
        }
   
            return null;    
    }
 
}
