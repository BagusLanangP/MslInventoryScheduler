<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLibur extends Model
{
    use HasFactory;
      // Nonaktifkan timestamps
    public $timestamps = false;

    protected $fillable = ['name', 'date'];
    public function apiLibur(){
        return $this->belongsTo(Schedule::class);
    }
}
