<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoPost extends Model
{
    protected $fillable = 
    [
        'post_id',
        'post_status',
        'comment_status',
    ];

    public $timestamps = false;

    public function post() {
        return $this->belongsTo('App\Post');
    }
}
