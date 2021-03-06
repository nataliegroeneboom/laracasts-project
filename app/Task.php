<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];


    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }

    public function incomplete(){
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');
    }

    public function activity(){
        return $this->morphMany(Activity::class, 'subject')->latest();
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
