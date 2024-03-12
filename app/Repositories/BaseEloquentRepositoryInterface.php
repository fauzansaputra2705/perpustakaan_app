<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;

interface BaseEloquentRepositoryInterface
{
    /**
     * @param Model $model
     * @return Model
     */
    public function setModel($model);

    /**
     * return current model
     *
     */
    public function getModel(): Model;

    /**
     * @param array<string> $columns
     */
    public function all($columns = ['*']): mixed;

    public function query(): Builder;

    /**
     * @param array<mixed> $data
     */
    public function create($data): Model;

    /**
     * @param Array<mixed> $data
     * @param Integer|null $id
     * @param String $attribute
     */
    public function update($data, $id, $attribute = "id"): ?Model;

    /**
     * @param array<mixed> $where
     * @param array<mixed> $values
     * @return Model
     */
    public function updateOrCreate($where, $values): ?Model;

    /**
     * @param ?Integer $id
     */
    public function find($id): ?Model;

    /**
     * @param ?Integer $id
     */
    public function findOrFail($id): Model;

    /**
     * @param String $field
     * @param String $condition
     * @param mixed $columns
     */
    public function findWhere($field, $condition, $columns): Builder;

    public function first(): ?Model;

    public function last(): ?Model;

    /**
     * @param Integer $id
     */
    public function next($id): ?Model;

    /**
     * @param Integer $id
     */
    public function before($id): ?Model;

    /**
     * @param String $attribute
     * @param Array<mixed> $values
     */
    public function whereIn($attribute, $values): mixed;

    /**
     * @param string $column
     */
    public function max($column): mixed;

    /**
     * @param string $column
     */
    public function min($column): mixed;

    /**
     * @param string $column
     */
    public function avg($column): mixed;

    /**
     * @param Integer $id
     */
    public function delete($id): mixed;

    public function truncate(): mixed;

    /**
     * @param string $columns
     */
    public function count($columns): int;

    /**
     * @param array<string> $columns
     * @param Integer $perPage
     */
    public function paginate($columns = ['*'], $perPage = 8): mixed;

    /**
     * @param Integer|Null $limit
     * @param Array<string> $columns
     */
    public function simplePaginate($limit = null, $columns = ['*']): mixed;

    /**
     * @param String $value
     * @param ?String $key
     * @return SupportCollection<string,int>
     */
    public function pluck($value, $key = null): SupportCollection;

    /**
     * @param array<string>|string $relations
     */
    public function with($relations): Builder;

    public function toSql(): String;
}
