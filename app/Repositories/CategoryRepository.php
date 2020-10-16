<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * CategoryRepository constructor
     * @param Category $category
     */
    public function __construct(Category $category) {
        $this->category = $category;
    }
    public function getAllPaginated(int $perpage){
        return $this->category->paginate($perpage);
    }
    public function save(Array $data){
        return $this->category->create($data);
    }
    public function update(Array $data, int $id){
        $category = $this->category->findOrFail($id);
        $category->fill($data);
        if($category->isDirty()) $category->save();
        return $category;
    }
    public function delete(int $id){
        $category = $this->category->findOrFail($id);
        $category->delete();
        return $category;
    }


}
