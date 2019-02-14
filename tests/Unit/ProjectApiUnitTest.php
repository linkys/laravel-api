<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectApiUnitTest extends TestCase
{
    public function test_get_all_projects()
    {
        $response = $this->get('/api/projects');

        $response->assertStatus(200);
    }

    public function test_get_single_project()
    {
        $response = $this->get('/api/projects/2');
        $response->assertStatus(200);

        $response = $this->get('/api/projects/9999999');
        $response->assertStatus(404);
    }

    public function test_create_remove_new_project()
    {
        $name = str_random('200');

        $data = [
            'name' => $name,
            'description' => 'Test',
            'status' => 'hold',
        ];

        $response = $this->json('POST', url('api/projects'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', [
            'name' => $name
        ]);

        $project_id = Project::where('name', $name)->first()->id;

        $response = $this->json('DELETE', url('api/projects/' . $project_id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', [
            'name' => $name
        ]);
    }

    public function test_update_project()
    {
        $name = str_random('200');

        $data = [
            'name' => $name,
            'description' => 'Test',
            'status' => 'hold',
        ];

        $project = Project::create($data);

        $new_name = str_random('200');
        $data['name'] = $new_name;
        $response = $this->json('PUT', url('api/projects/' . $project->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', [
            'name' => $new_name
        ]);

        $project->delete();
    }
}
