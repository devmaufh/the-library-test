<?php
namespace App\Dtos;

use App\Http\Requests\BookRequest;
use Spatie\DataTransferObject\DataTransferObject;

class BookDto extends DataTransferObject{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $author;

    /**
     * @var string
     */
    public $published_date;

    /**
     * @var string|null
     */
    public $user;

    /**
     *
     */
    public $is_borrowed;

    /**
     * @var int
     */
    public $category_id;

    public static function fromRequest( BookRequest $request ):self{
        return new Self([
            'name' => $request->get('name'),
            'author' => $request->get('author'),
            'published_date' => $request->get('published_date'),
            'user' => $request->get('user'),
            'is_borrowed' => $request->has('is_borrowed') ? $request->get('is_borrowed') : false,
            'category_id' => (int)$request->get('category_id')
        ]);
    }

}
