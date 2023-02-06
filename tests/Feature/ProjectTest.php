<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseMigrations;

    public function test_index_return_projects()
    {

        $project = new Project();
        $project->title = "example title";
        $project->description = "example description";
        // $project->img_url = "example img_url";
        $project->deploy = "example deploy";
        $project->repository = "example repository";


        $response = $this->get('api/projects');

        $response->assertStatus(200);

        $response->assertJson(['data' => []]);

        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'img_url',
                    'deploy',
                    'repository',
                    'type' => "example type",
                ]
            ]
        ]);
    }

    public function test_store_project_return_project()
    {

        $data = [
            'title' => "example title",
            'description' => "example description",
            'img_url' => "example",
            'deploy' => "example deploy",
            'repository' => "example repository",
            'type' => "example type",
        ];

        $response = $this->post('api/projects', $data);

        $response->assertStatus(200);

        $response->assertJson(['data' => []]);

        $response->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'title',
                'description',
                'img_url',
                'deploy',
                'repository',
                'type',
            ]
        ]);
    }

    
}
