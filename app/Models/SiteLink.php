<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteLink extends Model
{
    protected $fillable = [
        'facebook',
        'instagram',
        'tiktok',
        'snapchat',
        'x',
        'whatsapp',
        'youtube',
        'linkedin',
        'company_profile_pdf',
    ];

    // public function getProfilePdfUrlAttribute(): ?string
    // {
    //     if (! $this->company_profile_pdf) {
    //         return null;
    //     }

    //     return Storage::disk('public')->url($this->company_profile_pdf);
    // }
}
