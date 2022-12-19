<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class ImageController extends Controller
{
    /**
     * Devuelve un array con todas las imagenes de la bd
     * @return Renderable
     */
    public function index(): Renderable
    {
        $images = Image::with("user")
        ->withCount("likes", "comments")
        ->addSelect(['liked_by_user' => Like::select('id')
        ->where('user_id', auth()->id())
        ->whereColumn('image_id', 'images.id')])
        ->latest()
        ->paginate();

        return view("images.index", compact("images")); 
    }

    /**
     * devuelve las fotos favoritas del usuario autenticado
     * @return Renderable
     */
    public function images_fav(Request $request): Renderable{
        
        $images= Image::whereHas('likes', function($likes){
            $likes->where('user_id', Auth()->id());
        })
        ->withCount("likes", "comments")
        ->addSelect(['liked_by_user' => Like::select('id')
        ->where('user_id', auth()->id())
        ->whereColumn('image_id', 'images.id')])
        ->latest()
        ->paginate();        
        
        return view("images.images_fav", compact("images")); 
    }

     /**
     * devuelve las imagenes de un usuario concreto y los datos de ese usuario
     * Página perfil de usuario
     * @return Renderable
     */
    public function images_user(Request $request): Renderable{
        
        $images= Image::with("user")
        ->withCount("likes")
        ->withCount("comments")
        ->where("user_id", $request->user_id)
        ->addSelect(['liked_by_user' => Like::select('id')
        ->where('user_id', auth()->id())
        ->whereColumn('image_id', 'images.id')])
        ->latest()
        ->paginate();        
        $user = User::where("id", $request->user_id)->first();
        
        return view("images.show_profile", compact("user", "images")); 
    }

    /**
     * devuelve la vista detallada de la imagen con los comentarios que tiene
     * @param  \Illuminate\Http\Request  $request  //la id de la imagen que se quiere detallar
     * @return Renderable
     */
    public function image_detail(Request $request): Renderable{ 

        $image= Image::with("user")
        ->withCount("likes", "comments")
        ->where("id", $request->image_id)
        ->addSelect(['liked_by_user' => Like::select('id')
        ->where('user_id', auth()->id())
        ->whereColumn('image_id', 'images.id')])
        ->first();     

        $comments = Comment::with("user")
        ->where("image_id", $request->image_id)
        ->latest()
        ->paginate();   
        return view("images.image_detail", compact("image", "comments")); 
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    { 
        return view('images.create_image', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Guarda una nueva imagen en la bd.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => ['file','mimes:jpg,png,gif,jpeg','max:10072'],
            'description' => ['required', 'string', 'max:255'],
        ]);
        
        Image::create([
            'user_id' => $request->user_id,
            'image_path' => $request->file('avatar')->storePublicly('users_images'),
            'description' => $request->description,
            'create_at' => now(),
        ]);
        return redirect('images')->with('status', 'image-created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $image_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $image_id)
    {   
        $request->validate([
            'description' => ['required', 'string', 'max:255'],
        ]);
        $image = Image::find($image_id);
        $image->description = $request->description;
        $image->save();
        return redirect()->back()->with('status', 'image-updated');
    }

    /**
     * elimina una imagen
     * @param  int $image_id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($image_id)
    {
        //dd($image_id);
        $image=Image::findOrFail($image_id);

        //elimina la imagen del storage y de la bd
        if(\Storage::delete($image->image_path)){
            $image->delete();
        }
        
        return back()->with('status', 'image-deleted');
    }
}
