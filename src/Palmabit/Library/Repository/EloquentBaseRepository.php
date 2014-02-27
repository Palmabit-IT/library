<?php namespace Palmabit\Library\Repository;
/**
 * Class EloquentBaseRepository
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */

use Palmabit\Library\Repository\Interfaces\BaseRepositoryInterface;
use Event;

class EloquentBaseRepository implements BaseRepositoryInterface
{
    /**
     * The model: needs to be eloquent model
     * @var mixed
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Create a new object
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a new object
     * @param       id
     * @param array $data
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($id, array $data)
    {
        $obj = $this->find($id);
        Event::fire('repository.updating', [$obj]);
        $obj->update($data);
        return $obj;
    }

    /**
     * Deletes a new object
     * @param $id
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete($id)
    {
        $obj = $this->find($id);
        Event::fire('repository.deleting', [$obj]);
        return $obj->delete();
    }

    /**
     * Find a model by his id
     * @param $id
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Obtains all models
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }
} 