<?php

namespace App\Repositories;
//use Illuminate\Database\Eloquent\Model;
use App\Models\Division;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository implements RepositoryInterface
{

    /**      
     * @var Model      
     */     
    protected $model;   

    /**
     * BaseRepository constructor.
     *
     * @param  object  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Save entry
     *
     * @return mixed
     */
    public function save(array $attributes)
    {
        return $this->model->fill($attributes)->save();
    }

    /**
     * Create entry
     *
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Query
     *
     * @return mixed
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param  int  $id
     *
     * @return mixed
     */
    public function firstOrCreate(array $first, array $create)
    {
        return $this->model->firstOrCreate($first,$create);
    }

    /**
     * @param  string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid)
    {
        return $this->model->Uuid($uuid);
    }
}