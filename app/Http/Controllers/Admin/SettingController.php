<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingStore;

class SettingController extends Controller
{
    const FILES_FIELDS = [
        'site-favicon',
        'site-logo',
        'site-user-logo',
        'site-home-bg'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingStore $request)
    {
        $settings = $request->setting;

        foreach($settings as $key => $value) {
            $db_setting = Setting::where('key', $key)->first();

            // don't store anything if we cant find the setting in the db
            if (! $db_setting) {
                continue;
            }
            
            // store files in the storage dir
            if (in_array($key, self::FILES_FIELDS)) {
                $value = $value->store('settings');
            }

            $db_setting->value = $value;
            $db_setting->save();
        }

        return redirect()->route('admin.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        // TODO: Implement function
    }
}
