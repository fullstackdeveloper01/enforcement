<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteOffence extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'site_offences';

    public function site()
    {
        return $this->belongsTo(\App\Models\Setup\Site::class, 'site_id');
    }
}
