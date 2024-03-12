<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Model
 *
 * @property-read string|null $created_at
 * @property-read string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 * @mixin \Eloquent
 */
class Model extends Eloquent
{
    use HasFactory;

    /**
     * The attributes that are guarded
     *
     * @var array<string>
     */
    protected $guarded = [];

    public function getCreatedAtAttribute(?string $value): ?string
    {
        if ($value) {
            return $this->formatTimestamp($value);
        }
        return null;
    }

    public function getUpdatedAtAttribute(?string $value): ?string
    {
        return $this->formatTimestamp($value);
    }


    /**
     * Format the timestamp attribute.
     *
     * @param  string|null  $value
     */
    private function formatTimestamp($value): ?string
    {
        if ($value) {
            // @phpstan-ignore-next-line
            return date('Y-m-d H:i:s', strtotime($value));
        } else {
            return null;
        }
    }
}
