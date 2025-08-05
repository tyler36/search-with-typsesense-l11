<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /** @use Searchable */
    use Searchable;

    public function shouldBeSearchable(): bool
    {
        return !$this->archived;
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'category' => $this->category,
            'archived' => (bool) $this->archived,
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
