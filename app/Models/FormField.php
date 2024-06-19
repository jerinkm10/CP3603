<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'label', 'input_type', 'input_type_options'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
