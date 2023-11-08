<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setup\Site;
use App\Models\casemanagement\enviro\Enviro;

class Representation extends Model
{
    use HasFactory;
    protected $table = 'representation';
    protected $fillable = [
        'fpn_number','site_id','enviro_id','first_name','last_name','email',
        'address_line1','city','country','post_code','phone','amount','reason',
        'appeal_note','accept_statement','privacy_statement','upload'
    ];

    //Get reason.
    public function reasonData() {
        return $this->hasOne(ManualRepresentationReason::class,'id','reason');
    }

    //Get site.
    public function siteData() {
        return $this->hasOne(Site::class,'id','site_id');
    }

    public function enviroData() {
        return $this->hasOne(Enviro::class,'id','enviro_id');
    }
}
