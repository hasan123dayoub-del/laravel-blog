<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable=['name'];

    public function Blogs()
    {
        return $this->belongsToMany(Blog::class ,'blog_category');
    }

}
