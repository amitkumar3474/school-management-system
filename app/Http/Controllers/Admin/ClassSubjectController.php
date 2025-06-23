<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\ClassSubject;
use Illuminate\Validation\Rule;

class ClassSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::orderBy('id', 'desc')->paginate(10);
        $subjects = Subject::all();
        return view('admin.class-subjects.index', compact('classes','subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|array'
        ]);
        $class = ClassModel::find($request->class_id);
        $class->subjects()->sync($request->subject_id);

        return redirect()->route('admin.class-subjects.index')->with('success', 'Class & Subject added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editClass = ClassModel::find($id);
        $classes = ClassModel::orderBy('id', 'desc')->paginate(10);
        $subjects = Subject::all();
       return view('admin.class-subjects.index', compact('classes', 'subjects', 'editClass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|array'
        ]);

        $class = ClassModel::find($request->class_id);
        $class->subjects()->sync($request->subject_id);

        return redirect()->route('admin.class-subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassModel::find($id);
        $class->subjects()->detach();
        return redirect()->route('admin.class-subjects.index')->with('success', 'Subject detached from class successfully.');
    }
}
