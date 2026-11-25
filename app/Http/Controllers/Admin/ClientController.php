<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('sort_order')->latest('id')->get();

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'logo'       => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['logo']       = $request->file('logo')->store('clients', 'public');
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Client::create($data);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'تم إضافة العميل بنجاح');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('logo')) {
            if ($client->logo && Storage::disk('public')->exists($client->logo)) {
                Storage::disk('public')->delete($client->logo);
            }

            $data['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $client->update($data);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    public function destroy(Client $client)
    {
        if ($client->logo && Storage::disk('public')->exists($client->logo)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'تم حذف العميل بنجاح');
    }
}
