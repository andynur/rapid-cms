<?php

namespace App\Helpers;

class PaginationHelper
{
    public static function meta($pagination)
    {
        return [
            'current_page' => $pagination->currentPage(),
            'from' => $pagination->firstItem(),
            'last_page' => $pagination->lastPage(),
            'per_page' => $pagination->perPage(),
            'to' => $pagination->lastItem(),
            'total' => $pagination->total(),
        ];
    }
}
