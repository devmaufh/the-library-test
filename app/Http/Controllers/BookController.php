<?php

namespace App\Http\Controllers;

use App\Dtos\BookDto;
use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * @var $bookService
     */
    protected $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }
    public function index(Request $request){
        try {
            $perPage = $request->has('perpage') ? $request->perpage : 10;
            $queryParam = $request->has('search') ? $request->search : NULL;
            $res = $this->bookService->getBooks($perPage, $queryParam);
            return response()->json(['data' => $res], 200);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json(['error' => 'Error al guardar categorias'],500);
        }
    }

    public function store(BookRequest $request){
        try {
            $res = $this->bookService->saveBook(BookDto::fromRequest($request));
            return response()->json(['data' => $res], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al guardar libro'],500);
        }
    }
    public function update(BookRequest $request, $id){
        try {
            $res = $this->bookService->updateBook(BookDto::fromRequest($request), $id);
            return response()->json(['data' => $res], 200);

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json(['error' => 'Error al actualizar libro'],500);
        }
    }
    public function destroy($id){
        try {
            $res = $this->bookService->deleteBook($id);
            return response()->json(['data' => $res], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }

}
