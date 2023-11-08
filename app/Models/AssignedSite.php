<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedSite extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function site() {
        return $this->belongsTo('App\Models\Setup\Site');
    }
}
