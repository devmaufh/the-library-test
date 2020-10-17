<?php
namespace App\Services;

use App\Dtos\BookDto;
use App\Repositories\BookRepository;

class BookService{
    /**
     * @var $bookRepository;
     */
    protected $bookRepository;

    /**
     * BookService constructor
     * @param BookRepository $bookRepository;
     */
    public function __construct(BookRepository $bookRepository) {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Get all books
     * @param int $perpage
     * @param $filterValue
     */
    public function getBooks(int $perpage, $filterValue = NULL ){
        $filterColumns = ['books.name','books.author','books.published_date','books.user', 'c.name'];
        return $this->bookRepository->getAllPaginated($perpage, $filterValue, $filterColumns);
    }

    /**
     * Save a book
     * @param BookDto $data
     */
    public function saveBook(BookDto $data){
        return $this->bookRepository->save($data->toArray());
    }

    /**
     * Update a book
     * @param BookDto $data
     * @param int $id
     */
    public function updateBook(BookDto $data, int $id){
        return $this->bookRepository->update($data->toArray(), $id);
    }

    /**
     * Delete a book
     * @param $id
     */
    public function deleteBook(int $id){
        return $this->bookRepository->delete($id);
    }
}
