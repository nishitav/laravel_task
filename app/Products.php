<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {

    protected $fillable = ['name', 'price', 'upc', 'status', 'image'];

    /**
     * Model validation rules
     */
    public static function validationRules() {
        $results = [
            'name' => 'required',
            'price' => 'required',
            'upc' => 'required',
            'status' => 'required',
            'image' => 'required',
        ];

        return $results;
    }

}
