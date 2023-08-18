<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PostData extends Data
{
    public function __construct(
        public int $id,
        public string $topic,
        public string $created_at,
        public string $updated_at
    ) {
    }
}
