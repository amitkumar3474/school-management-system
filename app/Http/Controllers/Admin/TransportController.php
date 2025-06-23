<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageTitle = 'Transport List';

        $transports = Transport::whereNull('parent_route_id')->when($request->search, function ($query, $search) {
            $query->where('route_name', 'like', '%' . $search . '%')
            ->orWhere('start_place', 'like', '%' . $search . '%')
            ->orWhere('stop_place', 'like', '%' . $search . '%')
            ->orWhere('vehicle_no', 'like', '%' . $search . '%')
            ->orWhere('driver_name', 'like', '%' . $search . '%');
        })->orderBy('id','desc')->paginate(10)->appends($request->only('search'));

        $edittransport = null;
        $subroutes = [];

        if ($request->has('edit')) {
            $edittransport = Transport::where('parent_route_id')->findOrFail($request->edit);
            $subroutes = $edittransport->subRoutes;
        }
        return view('admin.transports.index', compact('transports', 'edittransport', 'pageTitle', 'subroutes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'route_name'     => 'required|string|max:255',
            'start_place'    => 'required|string|max:255',
            'remarks'        => 'nullable|string',
            'vehicle_no'     => 'required|string|max:50',
            'driver_name'    => 'required|string|max:255',
            'driver_phone'   => 'required|digits:10',
            'driver_license' => 'required|string|max:50',
            'fee'            => 'required|numeric|min:0',

            // Flat array validation
            'sub_start_place' => 'required|array',
            'sub_start_place.*' => 'required_with:sub_fee|string|max:255',
            'sub_fee' => 'required|array',
            'sub_fee.*' => 'required_with:sub_start_place|numeric|min:0',
        ], [
            'sub_start_place.*.required_with' => 'Each sub-route must have a start place.',
            'sub_fee.*.required_with' => 'Each sub-route must have a fee.',
            'sub_fee.*.numeric' => 'Sub-route fee must be a number.',
            'sub_fee.*.min' => 'Sub-route fee cannot be negative.',
        ]);

        // Create the main transport route
        $mainRoute = Transport::create([
            'route_name'      => $request->route_name,
            'start_place'     => $request->start_place,
            'stop_place'      => 'RK', // Default stop place
            'fee'             => $request->fee,
            'remarks'         => $request->remarks,
            'vehicle_no'      => $request->vehicle_no,
            'driver_name'     => $request->driver_name,
            'driver_phone'    => $request->driver_phone,
            'driver_license'  => $request->driver_license,
        ]);

        // Handle sub-routes
        $subStartPlaces = $request->sub_start_place ?? [];
        $subFees = $request->sub_fee ?? [];

        foreach ($subStartPlaces as $index => $startPlace) {
            $fee = $subFees[$index] ?? null;

            if (!empty($startPlace) && is_numeric($fee)) {
                Transport::create([
                    'route_name'      => $mainRoute->route_name,
                    'start_place'     => $startPlace,
                    'stop_place'      => 'RK',
                    'fee'             => $fee,
                    'remarks'         => $request->remarks,
                    'vehicle_no'      => $mainRoute->vehicle_no,
                    'driver_name'     => $mainRoute->driver_name,
                    'driver_phone'    => $mainRoute->driver_phone,
                    'driver_license'  => $mainRoute->driver_license,
                    'parent_route_id' => $mainRoute->id,
                ]);
            }
        }

        return redirect()->route('admin.transports.index')->with('success', 'Transport created successfully.');
    }
    // show view detail
    public function show(Transport $transport)
    {
        return response()->json([
            'route_name' => $transport->route_name,
            'start_place' => $transport->start_place,
            'stop_place' => $transport->stop_place,
            'vehicle_no' => $transport->vehicle_no,
            'driver_name' => $transport->driver_name,
            'driver_phone' => $transport->driver_phone,
            'driver_license' => $transport->driver_license,
            'fee' => $transport->fee,
            'remarks' => $transport->remarks,
            'sub_routes' => $transport->subRoutes()->get(['start_place', 'fee']),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transport $transport)
    {
        // dd($request->all());
        $request->validate([
            'route_name'     => 'required|string|max:255',
            'start_place'    => 'required|string|max:255',
            'vehicle_no'     => 'required|string|max:50',
            'driver_name'    => 'required|string|max:255',
            'driver_phone'   => 'required|digits:10',
            'driver_license' => 'required|string|max:50',
            'fee'            => 'required|numeric|min:0',
            'sub_start_place' => 'array',
            'sub_fee'         => 'array',
            'sub_start_place.*' => 'required|string|max:255',
            'sub_fee.*' => 'required|numeric|min:0',
        ], [
            'sub_start_place.*.required_with' => 'Each sub-route must have a start place.',
            'sub_fee.*.required_with' => 'Each sub-route must have a fee.',
            'sub_fee.*.numeric' => 'Sub-route fee must be a number.',
            'sub_fee.*.min' => 'Sub-route fee cannot be negative.',
        ]);
        // dd($request->all());
        // Update parent transport
        $transport->update($request->only([
            'route_name', 'start_place', 'stop_place', 'vehicle_no',
            'driver_name', 'driver_phone', 'driver_license', 'remarks', 'fee'
        ]));

        $ids = $request->sub_id ?? [];
        $startPlaces = $request->sub_start_place ?? [];
        $fees = $request->sub_fee ?? [];

        $submittedIds = [];

        // Handle sub-routes
        foreach ($startPlaces as $index => $startPlace) {
            $fee = $fees[$index];
            $id = $ids[$index] ?? null;
    
            if ($id) {
                // Update existing
                $sub = $transport->subRoutes()->where('id', $id)->first();
                if ($sub) {
                    $sub->update([
                        'start_place' => $startPlace,
                        'fee'         => $fee,
                    ]);
                    $submittedIds[] = $id;
                }
            } else {
                // Create new
                $new = Transport::create([
                    'route_name'      => $transport->route_name,
                    'start_place'     => $startPlace,
                    'stop_place'      => 'RK',
                    'fee'             => $fee,
                    'vehicle_no'      => $transport->vehicle_no,
                    'driver_name'     => $transport->driver_name,
                    'driver_phone'    => $transport->driver_phone,
                    'driver_license'  => $transport->driver_license,
                    'remarks'         => $transport->remarks,
                    'parent_route_id' => $transport->id,
                ]);
                $submittedIds[] = $new->id;
            }
        }

        // Delete removed sub-routes
        $existingIds = $transport->subRoutes()->pluck('id')->toArray();
        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            $transport->subRoutes()->whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.transports.index')->with('success', 'Transport updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $transport)
    {
        $transport->delete();

        return redirect()->route('admin.transports.index')->with('success', 'Transport deleted successfully.');
    }
}
