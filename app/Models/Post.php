<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['post_title', 'post_cover', 'post_text', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    //Escopo global de ordenação
    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('created_at', 'desc');
        });
    }
}
