<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SectionCollection extends ResourceCollection
{
    use Paginate;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array(
            'list' => $this->collection->map(function ($item): array {
                return array(
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'logo' => $item['logo'],
                    'users' => UserResource::collection($item['users'])
                );
            }),
            'paginate' => $this->paginate()
        );
    }
}
