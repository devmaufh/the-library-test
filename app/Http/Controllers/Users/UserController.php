<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            User::all();
        } catch (Exception $th) {
            dd($th);
        }
        return User::paginate(5);
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            // 'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ];
        $this->validate($request, $rules);
        $password = bcrypt($request->password);
        $user  =User::create([
            'name' => "DEFAIL",//$request->name,
            'email' => $request->email,
            'password' => $password
        ]);
        return response()->json(['user' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }
        if(!$user->isDirty()){
            return response()->json(['error' => 'Especifica valores distintos'], 400);
        }
        return response()->json(['user' => $user], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
