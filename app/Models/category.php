<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class category extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $guarded = ['id'];
    public $translatedAttributes = ['name'];

    public function product()
    {
        return $this->hasMany(product::class);
    }

}
