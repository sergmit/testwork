<?php

namespace App\Http\Resources;

trait Paginate
{
    /**
     * Get paginate meta data
     * @return array
     */
    public function paginate(): array
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'currentPage' => $this->currentPage(),
            'totalPages' => $this->lastPage()
        ];
    }
}
