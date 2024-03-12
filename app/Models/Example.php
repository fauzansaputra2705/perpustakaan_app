<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Example
 *
 * @property int $id
 * @property string $contoh
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Example newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Example newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Example query()
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereContoh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Example extends Model
{
    use HasFactory;

    protected $table = 'example';
}
