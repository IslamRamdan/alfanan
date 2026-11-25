<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteLinkController extends Controller
{
    public function index()
    {
        $siteLink = SiteLink::firstOrCreate([]);

        return view('admin.site-links.index', compact('siteLink'));
    }

    public function update(Request $request)
    {
        $siteLink = SiteLink::firstOrCreate([]);

        $data = $request->validate([
            'facebook'            => 'nullable|url|max:2048',
            'instagram'           => 'nullable|url|max:2048',
            'tiktok'              => 'nullable|url|max:2048',
            'snapchat'            => 'nullable|url|max:2048',
            'x'                   => 'nullable|url|max:2048',
            'whatsapp'            => 'nullable|string|max:2048',
            'youtube'             => 'nullable|url|max:2048',
            'linkedin'            => 'nullable|url|max:2048',
            'company_profile_pdf' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('company_profile_pdf')) {
            if ($siteLink->company_profile_pdf && Storage::disk('public')->exists($siteLink->company_profile_pdf)) {
                Storage::disk('public')->delete($siteLink->company_profile_pdf);
            }

            $data['company_profile_pdf'] = $request->file('company_profile_pdf')->store('company-profiles', 'public');
        } else {
            unset($data['company_profile_pdf']);
        }

        $siteLink->update($data);

        return redirect()
            ->route('admin.site-links.index')
            ->with('success', 'تم حفظ الروابط وملف الشركة بنجاح');
    }
}
