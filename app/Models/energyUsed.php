<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class energyUsed extends Model
{
    use HasFactory;
    public function appliance(){
        return $this->belongsTo(Appliance::class);
    }
}
