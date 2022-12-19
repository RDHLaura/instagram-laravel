<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        //dd($request->content_search);
        if($request->content_search != null){
            $users = User::where('username', 'LIKE', '%'.$request->content_search.'%')
                ->orWhere('name', 'LIKE', '%'.$request->content_search.'%')
                ->orWhere('surname', 'LIKE', '%'.$request->content_search.'%')
                ->orWhere('email', 'LIKE', '%'.$request->content_search.'%')
                ->latest()
                ->paginate();
                //dd($users);  
        }else{
            $users= User::latest()->paginate();
        }
        
              
        return view("users.users-index", compact("users")); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_user(Request $request)
    {
        $users = User::where('nick', 'LIKE', '%'.$request->content_search.'%')
        ->orWhere('name', 'LIKE', '%'.$request->content_search.'%')
        ->orWhere('surname', 'LIKE', '%'.$request->content_search.'%')
        ->orWhere('email', 'LIKE', '%'.$request->content_search.'%')
        ->orWhere('username', 'LIKE', '%'.$request->content_search.'%')
        ->latest()
        ->paginate();
        dd($request);
        //dd($images);        
        return view("users.users-index", compact("users")); 
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
