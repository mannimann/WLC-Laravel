<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
  use HasFactory;

  // protected $fillable = ["vorname", "name", "klasse", "von", "bis", "schritte"];

  protected $guarded = ["id", "created_at", "updated_at"];
}
