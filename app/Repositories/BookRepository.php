<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    /**
     * @var Book
     */
    protected $book;

    /**
     * BoolRepository constructor
     * @param Book $book
     */
    public function __construct(Book $book) {
        $this->book = $book;
    }

    /**
     * Get all books and filter books
     * @param int $perpage
     * @param $value,
     * @param Array $columnsToFilter
     */
    public function getAllPaginated(int $perpage, $value, Array $columnsToFilter = NULL){
        $books = $this->book->query()->join('categories as c', 'c.id','books.category_id');
        if($value !== NULL){
            $books->where(function($query) use($columnsToFilter, $value){
                foreach ($columnsToFilter as $column) {
                    $query->orWhere( $column, 'LIKE' , '%' . $value . '%' );
                }
            });
        }
        return $books->select('books.*','c.name as category')->paginate($perpage);
    }

    /**
     * Save a book
     * @param Array $data
     */
    public function save(Array $data){
        return $this->book->create($data);
    }

    /**
     * Update a book
     * @param Array $data
     * @param int $id
     */
    public function update(Array $data, int $id){
        $book = $this->book->findOrFail($id);
        $book->fill($data);
        if($book->isDirty()) $book->save();
        return $book;
    }

    /**
     * Delete a book
     * @param $id
     */
    public function delete(int $id){
        $book = $this->book->findOrFail($id);
        $book->delete();
        return $book;
    }
}
