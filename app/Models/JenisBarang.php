<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $fillable = ['name'];

    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }
}
