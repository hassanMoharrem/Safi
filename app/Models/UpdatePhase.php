<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UpdatePhase extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['last_date','time','next_date','station_id'];
    public function station(){
        return $this->belongsTo(DessertStation::class);
    }
}
