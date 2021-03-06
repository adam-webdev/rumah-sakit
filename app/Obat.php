<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obats';
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function rawatinaps(){
        return $this->belongsToMany(Rawatinap::class);
    }
}
