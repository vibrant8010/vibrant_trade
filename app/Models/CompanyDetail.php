<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $table = 'company_details';

    protected $fillable = [
        'business_id',
        'name',
        'logo_url',
        'description',
        'gst_registration_date',
        'gst_no',
        'legal_status',
        'nature_of_business',
        'alternate_names',
        'city',
        'state',
        'pincode',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }

        /**
     * Define a relationship to the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'business_id');
    }
}
