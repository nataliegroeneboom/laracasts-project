<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
      $this->signIn();
      $project = ProjectFactory::create();
      $this->actingAs($project->owner)
      ->post($project->path() . '/tasks', ['body' => 'Lorum Ipsum']);
      $this->get($project->path())
      ->assertSee('Lorum Ipsum');

    }

    /**
     * @test
     */
    public function a_task_requires_a_body(){
        $this->signIn();
        $project = ProjectFactory::create();
        $attributes = factory(Task::class)->raw(['body' => '']);
        
         $this->actingAs($project->owner)
         ->post($project->path() . '/tasks', $attributes)
         ->assertSessionHasErrors('body');   
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_can_add_tasks(){
        $this->signIn();
        $project = factory(Project::class)->create();
        $this->post($project->path() . '/tasks', ['body' => 'Lorum Ipsum'])
        ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Lorum Ipsum']);
    }

    /**
     * @test
     */
    function a_task_can_be_updated(){
       
        $this->signIn();

        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
         'body' => 'changed',
        ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
        ]);
    }

    /**
     * @test
     */
    function a_task_can_be_completed(){
       
        $this->signIn();

        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
         'body' => 'changed',
        'completed' => true  
        ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

       /**
     * @test
     */
    function a_task_can_be_marked_as_incomplete(){
       
       $this->withoutExceptionHandling();
        $this->signIn();

        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
        ->patch($project->tasks[0]->path(), [
         'body' => 'changed',
        'completed' => true  
        ]);
        $this->patch($project->tasks[0]->path(), [
            'body' => 'changed',
           'completed' => false  
           ]);
        $this->assertDatabaseHas('tasks', [
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function only_the_owner_of_a_project_can_update_tasks(){
        $this->signIn();
        $project = ProjectFactory::withTask(1)->create();
        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
        ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

}
