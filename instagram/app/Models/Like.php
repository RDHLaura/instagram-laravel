<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Like extends Model
{
    use HasFactory;
    protected $fillable = [        
        'image_id'
    ];
    
    //rellena el user_id automáticamente con el id del usuario
    protected static function boot(){
        parent::boot();
        if(!app()->runningInConsole()){
            self::creating(function (Like $like){
                $like->user_id = auth()->id();
            });
        }
    }  

    //establecer relaciones con las demás tablas
    public function image(): BelongsTo {
        return $this->belongsTo(Image::class);
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    //pone la hora en formato legible mediante la librería carbon
    public function getCreatedAtFormattedAttribute(): string {
        return \Carbon\Carbon::parse($this->created_at)->format('d-m-Y H:i');
    }   
}
