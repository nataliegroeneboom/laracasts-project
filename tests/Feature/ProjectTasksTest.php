<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use Tests\TestCase;
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
      $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
      $this->post($project->path() . '/tasks', ['body' => 'Lorum Ipsum']);
      $this->get($project->path())
      ->assertSee('Lorum Ipsum');

    }

    /**
     * @test
     */
    public function a_task_requires_a_body(){
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );
        $attributes = factory(Task::class)->raw(['body' => '']);
        
         $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');   
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
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );
        $task = $project->addTask('test task');
        $this->patch($project->path() . '/tasks/' . $task->id, [
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
    public function only_the_owner_of_a_project_can_update_tasks(){
        $this->signIn();
        $project = factory(Project::class)->create();
        $task = $project->addTask('test Task');
        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'changed'])
        ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

}
