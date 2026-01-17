<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Setting;

class SiteSettings extends Component
{
    use WithFileUploads;
    
    public $site_name, $site_description, $address, $phone, $email, $footer_text, $logo;
    public $current_logo;

    protected $rules = [
        'site_name' => 'required|string|max:255',
        'site_description' => 'nullable|string',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'footer_text' => 'nullable|string',
        'logo' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function mount()
    {
        $settings = Setting::pluck('value', 'key');
        $this->site_name = $settings['site_name'] ?? 'pharmacySys EPS';
        $this->site_description = $settings['site_description'] ?? 'Modern Pharmacy Management System';
        $this->address = $settings['address'] ?? '';
        $this->phone = $settings['phone'] ?? '';
        $this->email = $settings['email'] ?? '';
        $this->footer_text = $settings['footer_text'] ?? 'All rights reserved.';
        $this->current_logo = $settings['logo'] ?? null;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'footer_text' => $this->footer_text,
        ];

        // Handle logo upload
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->dispatch('settings-saved', 'Settings updated successfully!');
        $this->current_logo = $data['logo'] ?? $this->current_logo;
        $this->logo = null;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.settings.site-settings');
    }
}
