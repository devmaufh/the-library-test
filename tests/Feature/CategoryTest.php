<?php
namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest  extends TestCase
{
    use DatabaseMigrations;

    protected $endpoint = 'api/category';

    public function testCreateCategory(){
        $category = factory(Category::class)->create()->toArray();
        $response = $this->json('POST', $this->endpoint, $category);
        $response->assertCreated();
    }
    public function testGetAll(){
        $category = factory(Category::class)->create();
        $response = $this->json('GET',$this->endpoint);
        $response->assertJsonFragment(['data'=>[$category->toArray()]]);
        $response->assertOk();

    }
    public function testUpdateCategory(){
        $category = factory(Category::class)->create()->toArray();
        $category['name'] = 'updated';
        $response = $this->json('PUT', $this->endpoint . '/' .$category['id'], $category);
        $response->assertJsonFragment(['data' => $category]);
        $response->assertOk();
    }
    public function testDeleteCategory(){
        $category = factory(Category::class)->create();
        $response = $this->json('DELETE', $this->endpoint . '/' .$category->id);
        $response->assertJsonStructure(['data' => []]);
        $response->assertOk();
    }


}
