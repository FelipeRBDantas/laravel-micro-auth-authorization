<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPermissionUser;
use App\Http\Resources\PermissionResource;

class PermissionUserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }
    
    public function permissionsUser($identify)
    {
        $user = $this->model
                    ->where('uuid', $identify)
                    ->with('permissions')
                    ->firstOrFail();

        return PermissionResource::collection($user->permissions);
    }

    public function addPermissionUser(AddPermissionUser $request)
    {
        $user = $this->model->where('uuid', $request->user)->firstOrFail();

        $user->permissions()->attach($request->permissions);

        return response()->json(['message' => 'success']);
    }
}
