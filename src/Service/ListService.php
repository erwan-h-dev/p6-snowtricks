<?php

namespace App\Service;

class ListService
{
    public function typeMediaList(): array
    {
        return [
            'image' => 'image',
            'video' => 'video',
        ];
    }
}