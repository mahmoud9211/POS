<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class product extends Model implements TranslatableContract
{
    use HasFactory,Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['name','description'];

    protected $appends =  ['profit_percentage'];


    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function getProfitPercentageAttribute()
    {
        $profit = $this->selling_price - $this->purchase_price;

        $profit_percentage = $profit * 100 / $this->purchase_price;

        return number_format($profit_percentage,2);
    }

    public function order()
    {
        return $this->belongsToMany(order::class);
    }
}
