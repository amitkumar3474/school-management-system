<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::orderBy('id', 'desc')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric',
            'sections.*.name' => 'nullable|string|max:255'
        ]);
    
        $class = ClassModel::create($request->only('name', 'fee', 'description'));
    
        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                if (!empty($section['name'])) {
                    $class->sections()->create($section);
                }
            }
        }
    
        return redirect()->route('admin.classes.index')->with('success', 'Class and sections created!');
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
        $classes = ClassModel::orderBy('id', 'desc')->paginate(10);
        $class = ClassModel::with('sections')->findOrFail($id);
        return view('admin.classes.index', compact('class', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric',
            'sections.*.name' => 'nullable|string|max:255'
        ]);
    
        $class = ClassModel::findOrFail($id);

        $class->update($request->only('name', 'fee', 'description'));
        
        
        $existingSectionIds = $class->sections->pluck('id')->toArray();
        $submittedSectionIds = [];

        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                if (!empty($section['name'])) {
                    if (isset($section['id'])) {
                        $class->sections()->where('id', $section['id'])->update([
                            'name' => $section['name'],
                            'description' => $section['description'] ?? null
                        ]);
                        $submittedSectionIds[] = $section['id'];
                    } else {
                        $class->sections()->create([
                            'name' => $section['name'],
                            'description' => $section['description'] ?? null
                        ]);
                    }
                }
            }
        }
        $sectionsToDelete = array_diff($existingSectionIds, $submittedSectionIds);
        if (!empty($sectionsToDelete)) {
            $class->sections()->whereIn('id', $sectionsToDelete)->delete();
        }

        // $class->sections()->delete();

        // if ($request->has('sections')) {
        //     foreach ($request->sections as $section) {
        //         if (!empty($section['name'])) {
        //             $class->sections()->create($section);
        //         }
        //     }
        // }
    
        return redirect()->route('admin.classes.index')->with('success', 'Class and sections updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassModel::findOrFail($id);
        $class->subjects()->detach();
        $class->sections()->delete();
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted.');
    }



    public function getSections(){
        $sections = Section::with('class')->get()->groupBy('class_id');
        return view('admin.sections.index', compact('sections'));
    }
}
