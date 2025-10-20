<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
    ];

    // علاقة: كل وصفة تنتمي إلى تصنيف واحد
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة مستقبلية: كل وصفة فيها مكونات كثيرة (رح نضيفها لاحقًا)
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('quantity');
    }
}
