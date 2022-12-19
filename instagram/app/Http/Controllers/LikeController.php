<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $like = Like::where('user_id', auth()->id())->where('image_id', $request->image_id)->first();
        if($like == null){ //si el like no existe, lo crea
            Like::create([
                'image_id' => $request->image_id,
            ]);
        }else //si existe, llama a la función destroy y lo elimina
            $this->destroy($like);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        $like->delete();
        return back();
    }
}
