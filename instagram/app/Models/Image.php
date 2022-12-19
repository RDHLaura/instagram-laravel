<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    //muestra cuántas fotos se mostrarán por página
    protected $perPage = 15;

    //se protegen los datos rellenables para evitar ataques de asignación masiva
    protected $fillable = [
        "user_id",
        "image_path",
        "description"
        ];

    //rellena el user_id automáticamente con el id del usuario
    protected static function boot(){
        parent::boot();
        if(!app()->runningInConsole()){
            self::creating(function (Image $image){
                $image->user_id = auth()->id();
            });
        }
        
    }    

    //limita la muestra del contenido del comentario
    public function getExceptAttribute(){
        return Str::words(value: $this->description, words: 10);
    }

    //establece relaciones con las tabas
    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


    //pone la hora en formato legible mediante la librería carbon
    public function getCreatedAtFormattedAttribute(): string {
        return \Carbon\Carbon::parse($this->created_at)->format('d-m-Y');
    }
    
}
