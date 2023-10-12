<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_name',        
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function ProductRegister($request)
    {
        return $this->create([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
        ]);

    }

}
