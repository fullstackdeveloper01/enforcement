<?php

namespace App\Models\casemanagement\enviro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setup\Site;
use App\Models\Setup\Zone;
use App\Models\casemanagement\enviro\master\OffenceGroup;
use App\Models\casemanagement\enviro\Offender;

class Enviro extends Model
{
    use HasFactory;
    protected $table = 'tbl_enviro';
    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function offence()
    {
        return $this->belongsTo(OffenceGroup::class);
    }

    public function offender()
    {
        return $this->belongsTo(Offender::class);
    }
}
