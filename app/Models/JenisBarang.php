<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }
}
