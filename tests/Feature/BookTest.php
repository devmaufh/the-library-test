<?php
namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BookTest extends TestCase{
    use DatabaseMigrations;

    protected $endpoint = 'api/book';

    public function testCreateBook(){
        $category = factory(Category::class)->create()->toArray();
        $book = factory(Book::class)->create()->toArray();
        $response = $this->json('POST', $this->endpoint, $book);
        $response->assertCreated();
    }
    public function testGetAll(){
        factory(Category::class,10)->create();
        $book = factory(Book::class)->create();
        $response = $this->json('GET',$this->endpoint);
        $response->assertJsonStructure(['data'=>['current_page','data' => [],'first_page_url','last_page','last_page_url']]);
        $response->assertOk();
    }

    public function testUpdateBook(){
        $category = factory(Category::class)->create()->toArray();
        $book = factory(Book::class)->create()->toArray();
        $book['name'] = 'UPDATED';
        $response = $this->json('PUT', $this->endpoint . '/' .$book['id'], $book);
        $response->assertJsonStructure(['data' => []]);
        $response->assertOk();
    }
    public function testDeleteCategory(){
        $category = factory(Category::class)->create();
        $book = factory(Book::class)->create();
        $response = $this->json('DELETE', $this->endpoint . '/' .$book->id);
        $response->assertJsonStructure(['data' => []]);
        $response->assertOk();
    }
}
