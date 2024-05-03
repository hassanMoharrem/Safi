<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DessertStation extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'name_ar', 'phase', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function updatePhase(){
        return $this->hasMany(UpdatePhase::class);
    }

}
