<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table= 'article';
    protected $fillable = ['author','title','description','category_id','show_count'];

    public function category(){
        return $this->hasOne(Category::class ,'id','category_id');
    }
}
