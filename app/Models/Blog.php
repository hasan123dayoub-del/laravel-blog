<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable=[
        'title',
        'content',
        'image'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class,'favorites');
    }
}
