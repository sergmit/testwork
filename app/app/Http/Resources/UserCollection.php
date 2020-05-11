<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    use Paginate;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'list' => $this->collection->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'created_at' => $item['created_at']->format('Y-m-d H:i:s')
                ];
            }),
            'paginate' => $this->paginate()
        ];
    }
}
