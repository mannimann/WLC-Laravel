<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasse extends Model
{
  use HasFactory;

  protected $table = "klassen";

  protected $fillable = ["klasse", "kategorie"];
}
