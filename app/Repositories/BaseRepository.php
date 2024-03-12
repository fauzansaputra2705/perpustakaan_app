<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;

abstract class BaseRepository implements BaseEloquentRepositoryInterface
{
    /**
     *
     * @var Model
     */
    private $model;

    /**
     *
     * @var Model
     */
    protected $newInstanceModel;

    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * @return Model
     */
    abstract public function model();

    /**
     * return current model
     *
     * @return Model
     */
    final public function makeModel()
    {
        return $this->setModel($this->model());
    }

    /**
     * @param Model $model
     * @return Model
     */
    final public function setModel($model)
    {
        $this->newInstanceModel = $model;

        return $this->model = $this->newInstanceModel;
    }

    /**
     * return current model
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param array<string> $columns
     */
    public function all($columns = ['*']): mixed
    {
        return $this->model->all($columns);
    }

    public function query(): Builder
    {
        return $this->model->query();
    }

    /**
     * @param array<mixed> $data
     */
    public function create($data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param Array<mixed> $data
     * @param Integer|null $id
     * @param String $attribute
     */
    public function update($data, $id, $attribute = "id"): ?Model
    {
        $record = $this->model
            ->where($attribute, '=', $id)
            ->first();

        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    /**
     * @param array<mixed> $where
     * @param array<mixed> $values
     * @return Model
     */
    public function updateOrCreate($where, $values): ?Model
    {
        return $this->model->updateOrCreate($where, $values);
    }

    /**
     * @param ?Integer $id
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param ?Integer $id
     */
    public function findOrFail($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param String $field
     * @param String $condition
     * @param String $columns
     */
    public function findWhere($field, $condition, $columns): Builder
    {
        return $this->model->where($field, $condition, $columns);
    }

    public function first(): ?Model
    {
        return $this->model->first();
    }

    public function last(): ?Model
    {
        return $this->model->latest()->first();
    }

    /**
     * @param Integer $id
     */
    public function next($id): ?Model
    {
        return $this->model->where('id', '>', $id)->orderBy('id')->first();
    }

    /**
     * @param Integer $id
     */
    public function before($id): ?Model
    {
        return $this->model->where('id', '<', $id)->orderBy('id', 'desc')->first();
    }

    /**
     * @param String $attribute
     * @param Array<mixed> $values
     */
    public function whereIn($attribute, $values): mixed
    {
        return $this->model->whereIn($attribute, $values)->get();
    }

    /**
     * @param string $column
     */
    public function max($column): mixed
    {
        return $this->model->max($column);
    }

    /**
     * @param string $column
     */
    public function min($column): mixed
    {
        return $this->model->min($column);
    }

    /**
     * @param string $column
     */
    public function avg($column): mixed
    {
        return $this->model->avg($column);
    }

    /**
     * @param Integer $id
     */
    public function delete($id): mixed
    {
        return $this->model->destroy($id);
    }

    public function truncate(): mixed
    {
        return $this->model->truncate();
    }

    /**
     * @param string $columns
     */
    public function count($columns): int
    {
        return $this->model->count($columns);
    }

    /**
     * @param array<string> $columns
     * @param Integer $perPage
     */
    public function paginate($columns = ['*'], $perPage = 8): mixed
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param Integer|Null $limit
     * @param Array<string> $columns
     */
    public function simplePaginate($limit = null, $columns = ['*']): mixed
    {
        return $this->model->simplePaginate($limit, $columns);
    }

    /**
     * @param String $value
     * @param ?String $key
     * @return SupportCollection<string,int>
     */
    public function pluck($value, $key = null): SupportCollection
    {
        return $this->model->pluck($value, $key);
    }

    /**
     * @param array<string>|string $relations
     */
    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function toSql(): String
    {
        return $this->model->toSql();
    }

    /**
     * @param array<array<mixed>> $attr
     * @param Builder $data
     * @return Builder
     */
    public function whenWhere($attr, $data)
    {
        foreach ($attr as $item) {
            if (count($item) == 2) {
                $data->when(isset($item[1]) && $item[1] != '', function ($w) use ($item) {
                    $w->whereRaw("$item[0] = $item[1]");
                });
            } elseif (count($item) == 3) {
                //jika array
                if (is_array($item[2])) {
                    $val = $this->convertArray($item[2]);
                    $item[2] = "($val)";
                }

                $data->when(isset($item[2]) && $item[2] != '', function ($w) use ($item) {
                    $w->whereRaw("$item[0] $item[1] $item[2]");
                });
            }
        }
        return $data;
    }

    /**
     * @param   Array<mixed>  $data
     * @return  string
     */
    private function convertArray($data)
    {
        $val = '';
        foreach ($data as $k => $value) {
            $val .= "'" . $value . "'";
            $val .= count($data) - 1 == $k ? '' : ',';
        }
        return $val;
    }
}
