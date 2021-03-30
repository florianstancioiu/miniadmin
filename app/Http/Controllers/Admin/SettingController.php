<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingStore;

class SettingController extends Controller
{
    public function index()
    {
        $this->can('list-settings');

        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(SettingStore $request)
    {
        $this->can('store-settings');

        try {
            foreach ($request->settings as $key => $value) {
                $db_setting = Setting::where('key', $key)->first();

                // don't store anything if we cant find the setting in the db
                if (! $db_setting) {
                    continue;
                }

                // store images
                if ($db_setting->type === 'image') {
                    $value = $value->store('settings');
                }

                $db_setting->value = $value;
                $db_setting->save();
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings.index')
                ->withErrors([
                    'An exception was raised while updating the settings: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('message', 'The settings were successfully updated');
    }
}
