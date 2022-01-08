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
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'upc' => 'required|unique:products',
            'status' => 'required',
            'image' => 'required',
        ];

        return $results;
    }

}
