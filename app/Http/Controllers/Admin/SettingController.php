<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\AcademicSession;

class SettingController extends Controller
{

    public function index(){
        // dd($general->currency_format);
        $sessions = AcademicSession::all();
        return view('admin.settings.settings', compact('sessions'));

    }


    public function store(Request $request)
    {
        // dd($request->all());
        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('uploads/settings', 'public');
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } else {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        Cache::forget('GeneralSetting');
        // return redirect()->back()->with('success', 'Settings updated successfully!');
        return redirect()->back()->with([
            'success' => 'Settings updated successfully!',
            'submit_tab' => $request->submit_tab,
        ]);
    }
}
