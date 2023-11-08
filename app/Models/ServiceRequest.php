<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $table = 'tbl_service_requests';
    protected $fillable = [
        'site_id',
        'request_type_id',
        'busniness_waste_status',
        'complaint_option_status',
        'title',
        'job_title',
        'first_name',
        'last_name',
        'home_telephone',
        'work_telephone',
        'address',
        'email',
        'busniness_name',
        'busniness_address',
        'busniness_town',
        'busniness_country',
        'busniness_post_code',
        'reported_via_id',
        'officer_id',
        'address2',
        'ethnicity',
        'complaint_town',
        'gender',
        'complaint_country',
        'date_of_birth',
        'complaint_postal_code',
    ];
}
