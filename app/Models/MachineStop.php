<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineStop extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machine_stop';
}
