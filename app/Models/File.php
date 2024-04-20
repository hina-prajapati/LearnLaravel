<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable=[
        'images',
        'file_id',
    ];
 
    public function files(){
        return $this->belongsTo(FileUpload::class);
    }
}
