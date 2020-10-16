<?php

namespace App\Services;

use App\Dtos\CategoryDto;
use App\Repositories\CategoryRepository;
use Exception;

class CategoryService
{
    /**
     * @var $categoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllCategories(int $perpage){

        return $this->categoryRepository->getAllPaginated($perpage);
    }
    public function saveCategory( CategoryDto $data ){
        return $this->categoryRepository->save($data->toArray());
    }
    public function updateCategory( CategoryDto $data, int $id ){
        return $this->categoryRepository->update($data->toArray(), $id);
    }
    public function deleteCategory( int $id ){
        return $this->categoryRepository->delete( $id );
    }
}
