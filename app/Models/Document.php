<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'original_pdf_location',
        'modified_pdf_location',
    ];
}
