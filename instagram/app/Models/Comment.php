<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'content'
    ];

    //rellena el user_id automáticamente con el id del usuario
    protected static function boot(){
        parent::boot();
        if(!app()->runningInConsole()){
            self::creating(function (Comment $comment){
                $comment->user_id = auth()->id();
            });
        }
    }    
    //limita la muestra del contenido del comentario
    public function getExceptAttribute(){
        return Str::words(value: $this->content, words: 50);
    }
    //pone la hora en formato legible mediante la librería carbon
    public function getCreatedAtFormattedAttribute(): string {
        return \Carbon\Carbon::parse($this->created_at)->format('d-m-Y H:i');
    }

    //establece la relación con la tabla image
    public function images(): BelongsTo {
        return $this->belongsTo(Image::class);
    }

    //establece la relación con la tabla user
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
