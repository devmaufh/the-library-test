<?php

namespace App\Http\Controllers;

use App\Dtos\CategoryDto;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var $categoryService
     */
    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->has('perpage') ? $request->perpage : 10;
            $res = $this->categoryService->getAllCategories($perPage);
            return response()->json(['data' => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener categorias'],500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $res = $this->categoryService->saveCategory(CategoryDto::fromRequest($request));
            return response()->json(['data' => $res], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'No se pudo registrar la categoria'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $res = $this->categoryService->updateCategory(CategoryDto::fromRequest($request), $id);
            return response()->json(['data'=> $res]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'No se pudo editar la categoria'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.th
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $res = $this->categoryService->deleteCategory($id);
            return response()->json(['data' => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'No se pudo editar la categoria'], 500);
        }
    }
}
