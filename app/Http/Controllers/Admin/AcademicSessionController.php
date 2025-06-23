<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;

class AcademicSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = 'Academic Session Settings';

        $sessions = AcademicSession::when($request->search, function ($query, $search) {
            $query->where('session', 'like', '%' . $search . '%');
        })->orderBy('id','desc')->paginate(10)->appends($request->only('search'));

        $editsessions = $request->has('edit') ? AcademicSession::findOrFail($request->edit) : null;

        return view('admin.academic_session.index', compact('sessions', 'editsessions', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'session' => 'required|string',
        ]);

        AcademicSession::create($validated);

        return redirect()->route('admin.academic-sessions.index')->with('success', 'Session created!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'session' => 'required|string',
        ]);
        $session = AcademicSession::findOrFail($id);
        $session->update($validated);

        return redirect()->route('admin.academic-sessions.index')->with('success', 'Session updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $session = AcademicSession::findOrFail($id);
        $session->delete();
        return redirect()->route('admin.academic-sessions.index')->with('success', 'Session deleted!');
    }
}
