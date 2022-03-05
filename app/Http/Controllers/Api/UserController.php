<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Api\UserRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * @param UserRepository $usr
     */
    public function __construct(UserRepository $usr)
    {
        $this->user = $usr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return $this->user->getDatatableList();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->getById($id);
        $data = $this->user->getUserRole($user);

        return $this->success($data,trans('message.retrieve',['X' => 'User']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getToken()
    {
        $user = Auth::user();

        if ($user){

            return $this->success($user->createToken('authToken')->plainTextToken,'Success');
        }

        return $this->error('Unauthenticated',403);
    }

    public function userCheck(Request $request)
    {
        if (auth('sanctum')->check()){

            return $this->success(true,'Success');
        }

        return $this->error('Unauthenticated',403);
    }

    /**
    * The user has logged out of the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return mixed
    */
    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();
        
        return $this->success(true,'Success');
    }

    public function getListRoles()
    {
        $data = $this->user->getListRoles();

        return $this->success($data,trans('message.retrieve',['X' => 'roles']));
    }
}
