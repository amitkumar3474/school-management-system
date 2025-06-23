<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\TeacherExperience;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherClassSubject;
use App\Http\Controllers\Controller;
use App\Models\TeacherQualification;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $teachers = Teacher::with(['qualifications', 'experiences'])
        ->when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->paginate(10);
    
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastTeacher = Teacher::latest('id')->first();
        $nextIdNumber = $lastTeacher ? ((int) filter_var($lastTeacher->staff_id, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
        $generatedStaffId = 'Teac' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);
        return view('admin.teachers.create', compact('generatedStaffId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());    
        $request->validate([
            'staff_id' => 'required|unique:teachers,staff_id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'phone' => 'required|string',
            'email' => 'required|unique:teachers,email',
            'joining_date' => 'required|date',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|boolean',

            // Qualifications
            'qualifications.*.qualification' => 'required|string',
            'qualifications.*.specialization' => 'required|string',
            'qualifications.*.university' => 'required|string',
            'qualifications.*.passing_year' => [
                    'required',
                    'digits:4',
                    'integer',
                    'min:1900',           // Minimum valid year
                    'max:' . date('Y'),   // Maximum valid year (current year)
                ],
            'qualifications.*.grade' => 'required|string',

            // Experiences
            'experiences.*.school_name' => 'required|string',
            'experiences.*.position' => 'required|string',
            'experiences.*.from_date' => 'required|date',
            'experiences.*.to_date' => 'required|date|after_or_equal:experiences.*.from_date',
            'experiences.*.experience_years' => 'required|numeric|min:0|max:999.99',
            // validation for qualifications and experiences is handled below
        ]);
        // dd($request->all());
        DB::transaction(function () use ($request) {
            $data = $request->only([
                'user_id', 'staff_id', 'name', 'gender', 'dob', 'phone', 'email',
                'joining_date', 'address', 'blood_group', 'religion', 'marital_status', 'status'
            ]);

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('teachers', 'public');
            }

            $teacher = Teacher::create($data);

            // Save qualifications if any
            if ($request->has('qualifications')) {
                foreach ($request->qualifications as $qualification) {
                    $teacher->qualifications()->create($qualification);
                }
            }

            // Save experiences if any
            if ($request->has('experiences')) {
                foreach ($request->experiences as $experience) {
                    $teacher->experiences()->create($experience);
                }
            }
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = Teacher::findOrFail($id); // Use findOrFail for better error handling
        $teacher->load(['qualifications', 'experiences']);
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id); // Use findOrFail for better error handling
        $teacher->load(['qualifications', 'experiences']);
        return view('admin.teachers.create', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'staff_id' => 'required|unique:teachers,staff_id,' . $id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'phone' => 'required|string',
            'email' => 'required|unique:teachers,email,' . $id,
            'joining_date' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|boolean',

            // Qualifications
            'qualifications.*.qualification' => 'required|string',
            'qualifications.*.specialization' => 'required|string',
            'qualifications.*.university' => 'required|string',
            'qualifications.*.passing_year' => [
                'required',
                'digits:4',
                'integer',
                'min:1900',           // Minimum valid year
                'max:' . date('Y'),   // Maximum valid year (current year)
            ],
            'qualifications.*.grade' => 'required|string',

            // Experiences
            'experiences.*.school_name' => 'required|string',
            'experiences.*.position' => 'required|string',
            'experiences.*.from_date' => 'required|date',
            'experiences.*.to_date' => 'required|date|after_or_equal:experiences.*.from_date',
            'experiences.*.experience_years' => 'required|numeric|min:0|max:999.99',
            // validation for qualifications and experiences is handled below
        ]);

        DB::transaction(function () use ($request, $id) {
            $data = $request->only([
                'user_id', 'staff_id', 'name', 'gender', 'dob', 'phone', 'email',
                'joining_date', 'address', 'blood_group', 'religion', 'marital_status', 'status'
            ]);

            $teacher = Teacher::findOrFail($id);
            if ($request->hasFile('photo')) {
                if ($teacher->photo) {
                    Storage::disk('public')->delete($teacher->photo);
                }
                $data['photo'] = $request->file('photo')->store('teachers', 'public');
            }
            $teacher->update($data);

            // Update qualifications - delete old and insert new for simplicity
            $teacher->qualifications()->delete();
            if ($request->has('qualifications')) {
                foreach ($request->qualifications as $qualification) {
                    $teacher->qualifications()->create($qualification);
                }
            }

            // Update experiences - delete old and insert new for simplicity
            $teacher->experiences()->delete();
            if ($request->has('experiences')) {
                foreach ($request->experiences as $experience) {
                    $teacher->experiences()->create($experience);
                }
            }
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id); 
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    public function teacherClassSubjectList(Request $request)
    {
        $search = $request->input('search');
        $perPage = 10;

        $baseQuery = TeacherClassSubject::select('teacher_id', 'class_id', 'section_id')
            ->with(['teacher', 'class', 'section'])
            ->distinct();

        if ($search) {
            $baseQuery->where(function ($query) use ($search) {
                $query->whereHas('teacher', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('class', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('section', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }
        $groupedResults = $baseQuery->paginate($perPage);
        $groupedAssignments = collect();

        foreach ($groupedResults as $group) {
            $records = TeacherClassSubject::with(['teacher', 'class', 'section', 'subject'])
                ->where('teacher_id', $group->teacher_id)
                ->where('class_id', $group->class_id)
                ->where('section_id', $group->section_id)
                ->get();

            $groupedAssignments->push([
                'teacher_id' => $group->teacher_id,
                'class_id' => $group->class_id,
                'section_id' => $group->section_id,
                'records' => $records
            ]);
        }

        return view('admin.teachers.assign_class_subjects_list', [
            'assignments' => $groupedAssignments,
            'pagination' => $groupedResults
        ]);
    }

    public function teacherClassSubjectCreate(){
        $teachers = Teacher::where('status', 1)->get();
        $classes = ClassModel::all();
        return view('admin.teachers.assign_class_subjects_create', compact('teachers','classes'));
    }

    public function getSectionsAndSubjects($classId)
    {
        $sections = Section::where('class_id', $classId)->get();
        $class = ClassModel::with('subjects')->find($classId);

        return response()->json([
            'sections' => $sections,
            'subjects' => $class ? $class->subjects : []
        ]);
    }

    public function teacherClassSubjectStore(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'section_id.*' => 'required|numeric|exists:sections,id',
            'subject_id.*' => 'required|array|min:1',
            'subject_id.*.*' => 'numeric|exists:subjects,id',
        ]);
    
        $teacherId = $request->teacher_id;
        $combinations = [];
        $submittedKeys = [];
        // dd($request->all());
        foreach ($request->class_id as $i => $classId) {
            $sectionId = $request->section_id[$i];
            $subjectIds = $request->subject_id[$i] ?? [];
    
            foreach ($subjectIds as $subjectId) {
                $key = $classId . '-' . $sectionId . '-' . $subjectId;
                
                if (in_array($key, $submittedKeys)) {
                    return back()->with(['error' => 'Duplicate class-section-subject found in form.']);
                }
                $submittedKeys[] = $key;
    
                $existing = TeacherClassSubject::where([
                    'teacher_id' => $teacherId,
                    'class_id' => $classId,
                    'section_id' => $sectionId,
                    'subject_id' => $subjectId,
                ])->first();
                
                if (!$existing) {
                    TeacherClassSubject::create([
                        'teacher_id' => $teacherId,
                        'class_id' => $classId,
                        'section_id' => $sectionId,
                        'subject_id' => $subjectId,
                    ]);
                }
            }
        }
    
        $existingAssignments = TeacherClassSubject::where('teacher_id', $teacherId)->get();
    
        foreach ($existingAssignments as $assignment) {
            $key = $assignment->class_id . '-' . $assignment->section_id . '-' . $assignment->subject_id;
            if (!in_array($key, $submittedKeys)) {
                $assignment->delete();
            }
        }
        if ($request->input('action') === 'save_new') {
            return redirect()->route('admin.teacher.class.subjects.create')
                             ->with('success', 'Teacher assignments updated successfully.');
        } else {
            return redirect()->route('admin.teacher.class.subjects.list')
                             ->with('success', 'Teacher assignments updated successfully.');
        }
    }
    

    public function getTeacherAssignments($teacherId)
    {
        $assignments = TeacherClassSubject::where('teacher_id', $teacherId)
            ->get()
            ->groupBy(function ($item) {
                return $item->class_id . '-' . $item->section_id;
            });

        $result = [];

        foreach ($assignments as $group) {
            $result[] = [
                'class_id' => $group[0]->class_id,
                'section_id' => $group[0]->section_id,
                'subject_ids' => $group->pluck('subject_id')->toArray(),
            ];
        }

        return response()->json($result);
    }

    public function getAssignmentRow($index)
    {
        $classes = ClassModel::all();
        return view('admin.teachers.partials.assignment_row', compact('index', 'classes'))->render();
    }

    public function teacherClassSubjectEdit($id)
    {
        $teachers = Teacher::where('status', 1)->get();
        $classes = ClassModel::all();
        $assignment = TeacherClassSubject::with(['teacher'])->findOrFail($id);
        return view('admin.teachers.assign_class_subjects_create', compact('teachers', 'classes', 'assignment', 'teachers'));
    }

    public function teacherClassSubjectDelete($id)
    {
        $assignment = TeacherClassSubject::find($id);

        if (!$assignment) {
            return redirect()->back()->with('error', 'Assignment not found.');
        }
        $assignment->delete();
        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }
}
