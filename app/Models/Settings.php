<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'executor_document_text',
        'executor_document_phone',
        'about_text',
        'about_image',
        'request_email',
    ];
}
