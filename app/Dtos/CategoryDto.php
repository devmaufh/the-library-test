<?php

namespace App\Dtos;

use App\Http\Requests\CategoryRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryDto  extends DataTransferObject
{
    /** @var string  */
    public $name;

    /** @var string|null  */
    public $description;

    /**
     * returns Dto from request
     * @param CategoryRequest
     */
    public static function fromRequest( CategoryRequest $request ) : self{
        return new self([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);
    }


}
