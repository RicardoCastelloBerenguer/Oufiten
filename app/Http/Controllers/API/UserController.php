<?php

namespace App\Http\Controllers\API;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\API\UserListResource;
use App\Http\Resources\UserResource;
use App\Models\Api\User;
use App\Models\Customer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search',false);
        $perPage = request('per_page',20);
        $sortBy = request('sortBy','created_at');
        $order = request('order','desc');

        $query = User::query();
        if($search){
            $query->where('name','like',"%{$search}%");
        }
        $query->orderBy($sortBy,$order);

        return UserListResource::collection($query->paginate($perPage));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->validated();
        $data['is_admin'] = true;
        $data['email_verified_at'] = date('Y-m-d H:i:s');
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $customer = new Customer();

        $names =  explode(" " , $user->name);
        $customer->user_id=$user->id;
        $customer->first_name = $names[0];
        $customer->last_name = $names[1] ?? '';
        $customer->created_by=$request->user()->id;

        $customer->save();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserCreateRequest  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $User)
    {
        $data=$request->validated();

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $User->update($data);

        return new UserResource(($User));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            if(count($user->orders)){
                return response(['error' => 'El usuario contiene datos de pedidos']);
            }
            $user->delete();
            $user->customer->delete();
        }catch (\Exception $e){
            return response(['message' => $e]);
        }
        return response(['message' => 'Usuario borrado corectamente']);
    }
}
