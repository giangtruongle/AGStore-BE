<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = User::make()->latest()->get();
        return UserResource::collection($datas);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        if($user){
            return UserResource::make($user);
        }
        return response()->json(['error' => 'Something went wrong!'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(User::whereId($id)->first());
        // return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            // 'password'=>$request->password,
        ]);
        return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Delete Success!'], 201);
    }
}
