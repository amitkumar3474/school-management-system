<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $pageTitle = 'Admin Dashboard';
        return view('admin.dashboard', compact('pageTitle'));
    }
    /**
     * Get sections based on class ID.
     *
     * @param int $class_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get(['id', 'name']);
        return response()->json($sections);
    }
}
