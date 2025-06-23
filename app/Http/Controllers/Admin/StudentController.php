<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Transport;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Models\StudentEnrollment;
use App\Http\Controllers\Controller;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = 'Student List';
        $classes = ClassModel::all();
        $sessions = AcademicSession::all();
        
        // $students = Student::when($request->search, function ($query, $search) {
        //     $query->where('student_name', 'like', '%' . $search . '%')
        //           ->orWhere('father_name', 'like', '%' . $search . '%');
        // })
        // ->orderBy('id', 'desc')
        // ->paginate(10)
        // ->appends($request->only('search'));

        $defaultSessionId = gs()->academic_session_id;
        $sessionId = $request->session_id ?? $defaultSessionId;
        $students = StudentEnrollment::with(['student', 'class', 'section', 'academicSession', 'feeHistories'])
        ->when($request->class_id, function ($query, $classId) {
            $query->where('class_id', $classId);
        })
        ->when($request->section_id, function ($query, $sectionId) {
            $query->where('section_id', $sectionId);
        })
        ->when($request->session_id, function ($query, $sessionId) {
            $query->where('session_id', $sessionId);
        })
        ->where('session_id', $sessionId)
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->appends($request->only(['name', 'class_id', 'section_id', 'session']));

        return view('admin.students.index', compact('students', 'pageTitle' , 'classes', 'sessions', 'defaultSessionId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Add New Student';
        $classes = ClassModel::all();
        $sessions = AcademicSession::all();
        return view('admin.students.create', compact('classes', 'pageTitle', 'sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year_id' => 'required',
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required',
            'caste' => 'required',
            'guardian_mobile' => 'required|digits:10',
            'class_id' => 'required',
            'section_id' => 'nullable',
            'roll_no' => 'nullable|integer',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'student_name', 'father_name', 'mother_name', 'dob',
            'gender', 'caste', 'guardian_mobile', 'class_id'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student = Student::create($data);

        StudentEnrollment::create([
            'student_id' => $student->id,
            'session_id' => $request->year_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'roll_no' => $request->roll_no,
            'status' => 'Inactive',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student admitted successfully!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enrollment =StudentEnrollment::where('id', $id)->first();
        $pageTitle = 'Student Profile';
        return view('admin.students.show', compact('enrollment', 'pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Student';
        $classes = ClassModel::all();
        $sessions = AcademicSession::all();
        $transports = Transport::all();
        $enrollment =StudentEnrollment::where('id', $id)->first();
        return view('admin.students.edit', compact('enrollment', 'pageTitle', 'classes', 'sessions', 'transports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Validate student table fields
        $validatedStudent = $request->validate([
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required',
            'caste' => 'required',
            'guardian_mobile' => 'required|digits:10',
            'class_id' => 'required',
        ]);
        // enrollment table fields
        $validatedEnrollment = $request->validate([
            'year_id' => 'required',
            'section_id' => 'nullable',
            'roll_no' => 'nullable|integer',
        ]);
        // Guardian table fields
        $validatedGuardian = $request->validate([
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'guardian_mobile' => 'required|digits:10',
            'grd_relation' => 'required',
            'grd_occupation' => 'required',
            'grd_income' => 'required',
            'grd_education' => 'required',
            'grd_city' => 'nullable',
            'grd_state' => 'nullable',
            'grd_email' => 'nullable',
            'grd_address' => 'required',
        ]);
        // Validate required student_detail fields (marked with *)
        $validatedDetail = $request->validate([
            'aadhaar_number' => 'required',
            'religion' => 'required',
            'mother_tongue' => 'required',
            'date_of_admission' => 'required|date',
            'admission_no' => 'required',
            'bpl' => 'required',
            'weaker_section' => 'required',
            'rte_education' => 'required',
            'class_studied_previous_year' => 'required',
            'status_if_class_1st' => 'required',
            'attended_school' => 'nullable|integer',
            'mobile' => 'nullable|digits:10',
            'email' => 'nullable|email',
            'medium' => 'required',
            'disability_type' => 'required',
            'cwsn_facility' => 'required',
            'uniforms' => 'required',
            'textbook' => 'required',
            'transport' => 'required',
            'bicycle' => 'required',
            'escort_facility' => 'required',
            'midday_meal' => 'required',
            'hostel_facility' => 'required',
            'special_training' => 'required',
            'homeless_status' => 'required',
            'appeared_last_exam' => 'required',
            'passed_last_exam' => 'required',
            'stream' => 'required',
            'trade_sector' => 'required',
            'iron_folic_tablets' => 'required',
            'deworming_tablets' => 'required',
            'vitamin_a_tablets' => 'required',
        ]);
        if ($request->hasFile('photo')) {
            $validatedStudent['photo'] = $request->file('photo')->store('students', 'public');
        }
        $student->update($validatedStudent);

        $student->enrollment()->updateOrCreate(
            ['student_id' => $student->id],
            [
                'session_id' => $validatedEnrollment['year_id'],
                'class_id' => $validatedStudent['class_id'],
                'section_id' => $validatedEnrollment['section_id'],
                'roll_no' => $validatedEnrollment['roll_no'],
                'route_id' => $request->route_id,
                'status' => 'Active',
            ]
        );

        $student->detail()->updateOrCreate(
            ['student_id' => $student->id],
            $validatedDetail
        );
        $student->guardianDetail()->updateOrCreate(
            ['student_id' => $student->id],
            $validatedGuardian
        );
        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }

    /**
     * Promote student the specified resource from storage.
     */
    public function studentPromote(Request $request)
    {
        $pageTitle = 'Student Promote';
        $classes = ClassModel::all();
        $sessions = AcademicSession::all();
        $student_enrolls = [];
        if ($request->filled('class_id')) {
            $student_enrolls = StudentEnrollment::active()
            ->when($request->filled('session_id'), fn($q) => $q->where('session_id', $request->session_id))
            ->when($request->class_id, fn($q) => $q->where('class_id', $request->class_id))
            ->when($request->filled('section_id'), fn($q) => $q->where('section_id', $request->section_id))
            ->get();
        }
        return view('admin.students.promote', compact('pageTitle', 'student_enrolls', 'classes', 'sessions'));
    }
    /**
     * Promote student Store a newly created resource in storage.
     */
    public function promoteSubmit(Request $request)
    {
        $request->validate([
            'promote_year_id'     => 'required|integer',
            'promote_class_id'    => 'required|integer',
            'promote_section_id'  => 'nullable|integer',
            'class_status'        => 'required|array',
            'class_status.*'      => 'required|in:R,P',
        ]);

        foreach ($request->enroll_id as $index => $enrollId) {
            $currentEnroll = StudentEnrollment::findOrFail($enrollId);

            $promoteClassId    = $request->promote_class_id;
            $promoteSessionId  = $request->promote_year_id;
            $promoteSectionId  = $request->promote_section_id ?? null;
            $status            = $request->class_status[$index] ?? 'R';

            $isSameClass    = $currentEnroll->class_id == $promoteClassId;
            $isSameSession  = $currentEnroll->session_id == $promoteSessionId;

            if ($isSameClass && $isSameSession) {
                return back()->with('error', "Student is already in this class and session.");
            }

            if ($status === 'P') {
                $alreadyExists = StudentEnrollment::where('student_id', $currentEnroll->student_id)
                    ->where('session_id', $promoteSessionId)
                    ->where('class_id', $promoteClassId)
                    ->exists();

                if ($alreadyExists) {
                    return back()->with('error', "Student is already promoted to selected class and session.");
                }

                if ($isSameClass || $isSameSession) {
                    return back()->with('error', "Student is already in this class and session.");
                }

                $newEnroll = StudentEnrollment::create([
                    'student_id'       => $currentEnroll->student_id,
                    'session_id'       => $promoteSessionId,
                    'class_id'         => $promoteClassId,
                    'section_id'       => $promoteSectionId,
                    'route_id'         => $currentEnroll->route_id,
                    'promoted_from_id' => $currentEnroll->id,
                    'status'           => 'Active',
                ]);

                $currentEnroll->update(['status' => 'Promoted']);
            } else {

                if ($isSameSession) {
                    return back()->with('error', "Student is already in this class and session.");
                }
                $newEnroll = StudentEnrollment::create([
                    'student_id'       => $currentEnroll->student_id,
                    'session_id'       => $promoteSessionId,
                    'class_id'         => $currentEnroll->class_id,
                    'section_id'       => $currentEnroll->section_id,
                    'route_id'         => $currentEnroll->route_id,
                    'promoted_from_id' => $currentEnroll->id,
                    'status'           => 'Active',
                ]);
                $currentEnroll->update(['status' => 'Repeated']);
            }
        }

        return redirect()->route('admin.students.index')->with('success', 'Student promotion processed successfully.');
    }

    public function TC(Request $request)
    {
        $pageTitle = 'Generate TC';
        $classes = ClassModel::all();
        $sessions = AcademicSession::all();
        
        $defaultSessionId = gs()->academic_session_id;
        $sessionId = $request->session_id ?? $defaultSessionId;
        $students = StudentEnrollment::with(['student', 'class', 'section', 'academicSession', 'feeHistories'])
        ->when($request->student_id, function ($query, $studentId) {
            $query->where('student_id', $studentId);
        })
        ->when($request->class_id, function ($query, $classId) {
            $query->where('class_id', $classId);
        })
        ->when($request->section_id, function ($query, $sectionId) {
            $query->where('section_id', $sectionId);
        })
        ->when($request->session_id, function ($query, $sessionId) {
            $query->where('session_id', $sessionId);
        })
        ->where('session_id', $sessionId)
        ->active()
        ->orwhere('generate_tc', 1)
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->appends($request->only(['name', 'class_id', 'section_id', 'session']));

        return view('admin.students.tc', compact('students', 'pageTitle' , 'classes', 'sessions', 'defaultSessionId'));
    }

    public function getStudents($classId, $sectionId = null)
    {
        $query = StudentEnrollment::with('student')
            ->where('class_id', $classId)
            ->whereHas('student', function($q){
                $q->where('status', 'Active')->orwhere('generate_tc', 1);
            });

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        $enrollments = $query->get();

        $students = $enrollments->map(function ($enroll) {
            return [
                'id' => $enroll->student->id,
                'name' => $enroll->student->student_name,
            ];
        });

        return response()->json($students);
    }

    public function markTcGenerated($id)
    {
        $enrollment = StudentEnrollment::findOrFail($id);
        $enrollment->generate_tc = 1;
        $enrollment->status = 'Left';
        $enrollment->save();

        return redirect()->back()->with('success', 'Transfer Certificate marked as generated.');
    }



}
