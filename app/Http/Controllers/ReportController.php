<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        session(['title' => 'Reports']);
        $reports = Report::get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        session(['title' => 'Create Report']);

        $report = new Report();

        return view('reports.create', compact('report'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'year' => 'required',

        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();

                // Check if the request is an AJAX request
                if ($request->ajax()) {
                    return response()->json($message, 400);
                } else {
                    // Redirect back with an error message
                    return redirect()->route('index.opportunties')->with('error', $message);
                }
            } else {
                // Get the authenticated user
                $user = auth()->user();

                $reports = new Report();
                $report->title = $request->title;
                $report->desc = $request->desc;
                $report->year = $request->year;

                if ($request->hasFile('reports')) {
                    $reports = [];
                    foreach ($request->file('reports') as $index => $file) {
                        // Check if the file is a PDF
                        if ($file->getMimeType() == 'application/pdf') {
                            // Generate a unique file name
                            $file_extension = $file->getClientOriginalExtension();
                            $file_name = time().'_'.$index.'.'.$file_extension;

                            // Store the PDF file in the 'public/reports' directory
                            $file_path = $file->storeAs('documents/reports', $file_name, 'public');

                            // Add the file path to the array
                            $reports[] = $file_path;
                        }
                    }

                    // Assign the array of PDF file paths to the model attribute
                    $report->reports = $reports;
                }

                $report->save();
                if ($request->ajax()) {
                    // Return JSON response with reports information
                    return response()->json([
                        'message' => 'Report has been created successfully',
                        'reports' => $reports,
                    ], 200);
                } else {
                    // Redirect back with a success message
                    return redirect()->route('index.reports')->with('success', 'Report has been created successfully');
                }
            }
        } catch (Exception $e) {
            // Handle exceptions as needed...

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred.'], 500);
            } else {
                // Redirect back with an error message
                return redirect()->route('index.reportss')->with('error', 'An error occurred.');
            }
        }
    }

    public function edit($id)
    {
        session(['title' => 'Edit Report']);

        $report = Report::find($id);

        return view('reports.create', compact('report'));
    }

    public function confirmDelete($id)
    {
        session(['title' => 'Confirm Delete']);
        $report = Report::find($id);

        return view('reports.confirm_delete', compact('report'));
    }

    public function delete(Request $request)
    {
        $report = Report::find($request->id);

        $report->delete();

        return redirect()->route('index.reports');
    }

    public function getReports()
    {
        $reports = Report::get();

        return response()->json($reports);
    }

    public function search(Request $request)
    {
        $builder = Report::query()->with('report_name');
        $builder->where('report_name', '%'.$request->input('query').'%');

        return response()->json($builder->get());
    }

    public function getReport($id)
    {
        // Get a single category
        $report = Report::find($id);

        return response()->json($report);
    }

    public function show($category_id)
    {
        $report = Report::find($category_id);

        return view('reports.show', compact('report'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'report_name' => 'required',
            'phone' => 'required',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $report = Category::find($id);
        $report->report_name = is_null($request->report_name) ? $report->report_name : $request->report_name;
        $report->phone = is_null($request->phone) ? $report->phone : $request->phone;

        if ($image = $request->file('profile_pic')) {
            $destinationPath = 'profile_pic/';
            $profileImage = date('YmdHis').'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $report['profile_pic'] = "$profileImage";
        }

        $report->save();

        return redirect()->route('reports.index')
            ->with('success', 'Report Has Been updated successfully');
    }

    public function destroy(report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Report has been deleted successfully');
    }
}
