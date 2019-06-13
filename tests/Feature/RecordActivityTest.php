<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function creating_a_project()
    {
     $project = ProjectFactory::create();   
     $this->assertCount(1, $project->activity);
     $this->assertEquals('created',$project->activity[0]->description);
    }

    /**
     * @test
     */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();   
        $project->update([
            'title' => 'changed'
        ]);
        $this->assertCount(2, $project->activity);   
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function creating_a_new_task()
    {
        $project = ProjectFactory::create(); 
        $project->addTask('Some Task');
        $this->assertCount(2, $project->activity); 

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /**
     * @test
     */
    public function completing_a_task()
    {
        $project = ProjectFactory::withTask(1)->create(); 
        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);
        $this->assertCount(3, $project->activity); 
         

          tap($project->activity->last(), function($activity){ 
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /**
     * @test
     */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTask(1)->create(); 

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);
        $this->assertCount(3, $project->activity);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $this->assertCount(4, $project->fresh()->activity);
          $this->assertEquals('incompleted_task', $project->fresh()->activity->last()->description); 

    }

    /**
     * @test
     */
    function deleting_a_task()
    {
        $project = ProjectFactory::withTask(1)->create(); 
        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
    


}
