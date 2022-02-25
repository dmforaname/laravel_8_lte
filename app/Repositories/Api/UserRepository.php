<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Repositories\BaseRepository;
use DataTables;

class UserRepository extends BaseRepository
{
    protected $model;

    /**
     * Repository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUserRole()
    {
        return $this->model->with('roles')->latest()->get();
    }

    public function getDatatableList()
    {
        $data = self::getUserRole();

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('roles', function($data) {

            return $data->roles->first()->name;
        })
        ->make(true);
    }
}