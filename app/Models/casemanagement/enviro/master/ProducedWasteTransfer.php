<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProducedWasteTransfer extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_produced_waste_transfer';
    protected $fillable = [
        'waste_transfer','status'
    ];
}
