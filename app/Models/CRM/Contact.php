<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'company', 'designation'];

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}
