<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['nome','email','telefone','csv_file','logo_file','nome_empresa','apelido'];
}
