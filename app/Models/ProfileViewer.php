<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileViewer extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'viewed_by'];

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function profileViewer(){
    	return $this->belongsTo(User::class, 'viewed_by');
    }
}
