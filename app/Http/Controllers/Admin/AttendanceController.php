<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\AttendanceDay;
use Illuminate\Support\Carbon;
use App\Models\AttendanceMonth;
use App\Models\StudentEnrollment;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $request->validate([
        //     'attendance_type' => 'required|in:daily,monthly',
        //     'date' => 'required_if:att_type,daily|date',
        //     'month' => 'required_if:att_type,monthly|date_format:Y-m',
        //     'class_id' => 'required',
        //     'section_id' => 'nullable',
        // ]);

        $pageTitle = 'Attendance List';
        $classes = ClassModel::all();
        $student_enrolls = [];
        $attendanceExists = '';
        if ($request->filled('class_id')) {
            $attendanceType = $request->get('attendance_type', 'daily');
            $date = Carbon::parse($request->get($attendanceType === 'daily' ? 'date' : 'month', now()));

            $student_enrolls = StudentEnrollment::active()->with([ $attendanceType === 'daily' ? 'attendanceDays' : 'attendanceMonths' ])
            ->activeSession()
            ->where('class_id', $request->class_id)
            ->when($request->filled('section_id'), fn($q) => $q->where('section_id', $request->section_id))
            ->get();

            $attendanceExists = $student_enrolls->contains(function ($enroll) use ($attendanceType, $date) {
                return $attendanceType === 'daily' ? $enroll->attendanceDays->contains('att_date', $date->format('Y-m-d'))
                    : $enroll->attendanceMonths->contains(fn($record) =>
                        $record->month == $date->format('m') && $record->year == $date->format('Y')
                    );
            });

            foreach ($student_enrolls as $enroll) {
                if ($attendanceType === 'daily') {
                    $record = $enroll->attendanceDays->firstWhere('att_date', $date->format('Y-m-d'));
                    $enroll->attendance_status = $record->status ?? null;
                    $enroll->attendance_remark = $record->remark ?? '';
                } else {
                    $record = $enroll->attendanceMonths->where('year', $date->format('Y'))->firstWhere('month', $date->format('m'));
                    $enroll->present_count = $record->present ?? 0;
                    $enroll->absent_count = $record->absent ?? 0;
                }
            }
        }
        return view('admin.attendance.index', compact('pageTitle', 'classes', 'student_enrolls', 'attendanceExists'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'att_type'     => 'required|in:daily,monthly',
            // 'class_id'     => 'required|exists:class_models,id',
            // 'section_id'   => 'nullable|exists:sections,id',
            'class_id'     => 'required',
            'section_id'   => 'nullable',
            'attendance'   => 'required|array',
            'att_date'         => 'required_if:att_type,daily|date',
            'month'        => 'required_if:att_type,monthly|date_format:Y-m',
        ]);
    
        $classId    = $request->class_id;
        $sectionId  = $request->section_id;
    
        if ($request->att_type === 'daily') {
            $date = Carbon::parse($request->att_date);
    
            foreach ($request->enroll_ids as $index => $enrollId) {
                $record = $request->attendance[$index];
    
                AttendanceDay::updateOrCreate(
                    [
                        'enroll_id' => $enrollId,
                        'att_date' => $date->toDateString(),
                    ],
                    [
                        'class_id' => $classId,
                        'section_id' => $sectionId,
                        'month' => $date->month,
                        'year' => $date->year,
                        'status' => $record['status'],
                        'remark' => $record['remark'] ?? null,
                    ]
                );
    
                // Recalculate monthly attendance
                $summary = AttendanceDay::selectRaw("SUM(CASE WHEN status = 'P' THEN 1 ELSE 0 END) AS present, SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) AS absent ")
                    ->where('enroll_id', $enrollId)
                    ->whereMonth('att_date', $date)
                    ->whereYear('att_date', $date)
                    ->first();

                $present = $summary->present ?? 0;
                $absent  = $summary->absent ?? 0;
    
                AttendanceMonth::updateOrCreate(
                    [
                        'enroll_id' => $enrollId,
                        'month' => $date->month,
                        'year' => $date->year,
                    ],
                    [
                        'class_id' => $classId,
                        'section_id' => $sectionId,
                        'present' => $present,
                        'absent' => $absent,
                    ]
                );
            }
    
            return redirect()->route('admin.attendance.index')->with('success', 'Daily attendance has been saved successfully!');
        }
        // Monthly attendance handling
        if ($request->att_type === 'monthly') {
            $month = Carbon::parse($request->month);
            $workingDays = collect(range(1, $month->daysInMonth))
                ->map(fn($d) => Carbon::create($month->year, $month->month, $d))
                ->reject(fn($date) => $date->isSunday())
                ->values();
        
            foreach ($request->enroll_ids as $enrollId) {
                $data = $request->attendance[$enrollId];
                $present = (int) $data['present'];
                $absent  = (int) $data['absent'];
        
                if ($present + $absent > $workingDays->count()) {
                    return back()->with('error', "Total (P+A) exceeds working days ({$workingDays->count()})")->withInput();
                }
        
                AttendanceMonth::updateOrCreate(
                    ['enroll_id' => $enrollId, 'month' => $month->month, 'year' => $month->year],
                    ['class_id' => $request->class_id, 'section_id' => $request->section_id, 'present' => $present, 'absent' => $absent]
                );
        
                // Optional: Also save in AttendanceDay
                $statusMap = array_merge(array_fill(0, $present, 'P'), array_fill(0, $absent, 'A'));
                foreach ($workingDays as $i => $date) {
                    if (!isset($statusMap[$i])) break;
        
                    AttendanceDay::updateOrCreate(
                        ['enroll_id' => $enrollId, 'att_date' => $date->toDateString()],
                        ['class_id' => $request->class_id, 'section_id' => $request->section_id, 'status' => $statusMap[$i],'month' => $date->format('m'), 'year'  => $date->format('Y')]
                    );
                }
            }
        
            return redirect()->route('admin.attendance.index')->with('success', 'Monthly attendance has been saved successfull!.');
        }
    }
}
