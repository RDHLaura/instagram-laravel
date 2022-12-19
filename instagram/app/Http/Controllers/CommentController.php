<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valida el texto de entrada
        $request->validate([
            'comment' => ['required', 'string', 'max:255'],
        ]);
        
        //crea el nuevo comentario
        Comment::create([ 
            'user_id' => auth()->id(),          
            'image_id' => $request->image_id,
            'content' => $request->comment,
        ]);
        return back()->with('status', 'comment-created');
    }


    /**
     * guarda los cambios en el comentario y devuelve el estatus de comentario guardado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->content = $request->comment_content;
        $comment->save();
        return back()->with('status', 'comment-updated');
    }

    /**
     * Elimina el comentario y devuelve a la pagina con el estatus de comentario borrado
     * @param  int $comment_id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {   
        $comment=Comment::find($comment_id);
        $comment->delete();
        return back()->with('status', 'comment-deleted');
    }
}
