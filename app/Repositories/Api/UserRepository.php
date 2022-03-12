<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Repositories\BaseRepository;
use DataTables;
use Spatie\Permission\Models\Role;

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

    public function getUserWithRole()
    {
        return $this->model->with('roles')->latest()->get()
            ->makeHidden(['id','created_at','updated_at','email_verified_at']);
    }

    public function getDatatableList()
    {
        return Datatables::of(self::getUserWithRole())
        ->addIndexColumn()
        ->addColumn('roles', function($data) {

            return $data->roles->first()->name;
        })
        ->setRowId(function ($data) {
            return $data->uuid;
        })
        ->setRowClass(function ($data) {
            return "clickRow";
        })
        ->make(true);
    }

    public function getUserRole($user)
    {
        $collection = collect($user);
        $role = $user->roles->pluck('name');
        //$permission = $user->getPermissionsViaRoles()->pluck('name')->unique();
        $collection->put('role',$role->first());
        //$collection->put('permission',$permission);

        return $collection;
    }

    public function getListRoles()
    {
        return Role::all()->pluck('name');
    }

    public function updateRole($data,$request)
    {
        $role = self::getUserRole($data);
        $data->removeRole($role['role']);
        $data->assignRole($request->role);
        return true;
    }

    
}