<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Models\StudentEnrollment;
use App\Models\StudentFeeHistory;
use App\Http\Controllers\Controller;

class FeeController extends Controller
{
    public function generateBulk(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        $enrollments = StudentEnrollment::with(['class', 'transport']) // assuming transport relation on student
            ->whereIn('id', $ids)
            ->get();
            

        foreach ($enrollments as $enrollment) {
            $totalFeeAdded = 0;
            // Tuition Fee
            $tuitionExists = StudentFeeHistory::where('enrollment_id', $enrollment->id)
            ->where('label', 'Tuition Fee')
            ->exists();
            
            if (!$tuitionExists && $enrollment->class && $enrollment->class->fee) {
                StudentFeeHistory::create([
                    'enrollment_id' => $enrollment->id,
                    'label' => 'Tuition Fee',
                    'amount' => $enrollment->class->fee,
                    'action' => '+',
                    'note' => 'Auto-generated tuition fee for class ' . $enrollment->class->name,
                ]);
                $totalFeeAdded += $enrollment->class->fee;
            }

            // Transport Fee
            $transportExists = StudentFeeHistory::where('enrollment_id', $enrollment->id)
            ->where('label', 'Transport Fee')
            ->exists();

            if (!$transportExists && $enrollment->transport && $enrollment->transport->fee) {
                StudentFeeHistory::create([
                    'enrollment_id' => $enrollment->id,
                    'label' => 'Transport Fee',
                    'amount' => $enrollment->transport->fee,
                    'action' => '+',
                    'note' => 'Auto-generated transport fee',
                ]);
                $totalFeeAdded += $enrollment->transport->fee;
            }

            if ($totalFeeAdded > 0) {
                $enrollment->update([
                    'total_fee' => $enrollment->total_fee + $totalFeeAdded,
                    'pending_fee' => $enrollment->pending_fee + $totalFeeAdded,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Fees generated successfully for selected students.');
    }


    public function feeStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'enrollment_id' => 'required|exists:student_enrollments,id',
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        $enrollment = StudentEnrollment::findOrFail($request->enrollment_id);

        StudentFeeHistory::create([
            'enrollment_id' => $enrollment->id,
            'label' => $request->label,
            'amount' => $request->amount,
            'action' => '-',
            'note' => 'Manual fee entry: ' . $request->label,
            'payment_date' => $request->payment_date
        ]);
        
        $enrollment->update([
            'pending_fee' => $enrollment->pending_fee - $request->amount
        ]);
    
        // return redirect()->route('admin.students.index')->with('success', 'Fee submitted successfully.');
        return redirect()->back()->with('success', 'Fee submitted successfully.');
    }

    public function storeOtherCharges(Request $request){
        $request->validate([
            'label'          => 'required|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'enrollment_ids' => 'required|string',
        ]);
    
        $ids = explode(',', $request->enrollment_ids);
        
        $enrollments = StudentEnrollment::whereIn('id', $ids)
            ->get();

        foreach ($enrollments as $enrollment) {

            $otherExists = StudentFeeHistory::where('enrollment_id', $enrollment->id)
            ->where('label', $request->label)
            ->exists();
            if (!$otherExists){
                StudentFeeHistory::create([
                    'enrollment_id' => $enrollment->id,
                    'label'         => $request->label,
                    'amount'        => $request->amount,
                    'action'        => '+',
                    'note'          => 'Auto-generated ' . $request->label,
                ]);
                $enrollment->update([
                    'total_fee' => $enrollment->total_fee + $request->amount,
                    'pending_fee' => $enrollment->pending_fee + $request->amount,
                ]);
            }
        }
    
        return back()->with('success', $request->label .' added successfully.');
    }

    public function getStudents($sessionId,$classId, $sectionId = null)
    {
        $query = StudentEnrollment::with('student')
            ->where('class_id', $classId)
            ->where('session_id', $sessionId)
            ->where('total_fee', '!=', 0);
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

    public function fee(Request $request)
    {
        $pageTitle = 'Fee';
        $classes = ClassModel::all();
        $sessions = AcademicSession::all();
    
        $defaultSessionId = gs()->academic_session_id;
        $sessionId = $request->session_id ?? $defaultSessionId;
    
        $enrollment = null;
    
        // Check if all filters are filled
        if ($request->filled(['student_id', 'class_id', 'section_id', 'session_id'])) {
            echo "DFsfsd";
            $enrollment = StudentEnrollment::with(['student', 'class', 'section', 'academicSession', 'feeHistories'])
                ->where('student_id', $request->student_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->where('session_id', $sessionId)
                ->where('total_fee', '!=', 0)
                ->first();
        }
        return view('admin.fees.fee', compact('enrollment', 'pageTitle', 'classes', 'sessions', 'defaultSessionId'));
    }
    
}
