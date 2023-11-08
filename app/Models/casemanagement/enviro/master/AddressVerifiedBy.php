<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressVerifiedBy extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_address_verified_by';
    protected $fillable = [
        'textOnMachine', 'textOnLetter', 'status'
    ];
}
