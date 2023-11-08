<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offence extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_offence';
    protected $fillable = [
        'name', 'welshName', 'description', 'welshDescription', 'englishLegislation', 
        'welshLegislation', 'group', 'minImageRequired', 'maxFine', 'issueType', 'status'
    ];

    //Get legislation data.
    public function engLegislation()
    {
        return $this->hasOne(Legislation::class,'id','englishLegislation');
    }

    //Get legislation data.
    public function welLegislation()
    {
        return $this->hasOne(Legislation::class,'id','welshLegislation');
    }

    //Get offence group data.
    public function offenceGroup()
    {
        return $this->hasOne(OffenceGroup::class,'id','group');
    }
}
