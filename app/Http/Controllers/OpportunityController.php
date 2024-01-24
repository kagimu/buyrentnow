<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

use App\Models\Opportunity;

class OpportunityController extends Controller
{
      public function index()
    {
        session(['title' => 'Opportunities']);
        $opportunities = Opportunity::get();
        return view('opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        session(['title' => 'Create Opportunity']);

        $opportunity = new Opportunity();

        return view('opportunities.create', compact('opportunity'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'desc' => 'required',
            'date' => 'required',
            
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

                $opportunities = new Opportunity();
                $opportunity->title = $request->title;
                $opportunity->desc = $request->desc;
                $opportunity->date = $request->date;
                

            if ($request->hasFile('cover_pic')) {
                    $imageName = time() . "." . $request->cover_pic->extension();
                    $request->cover_pic->storeAs('public/opportunities', $imageName);
                    $opportunity->cover_pic = url(Storage::url('opportunities/' . $imageName));
                }

                if ($request->hasFile('documents')) {
                    $documents = [];
                    foreach ($request->file('documents') as $index => $file) {
                        // Check if the file is a PDF
                        if ($file->getMimeType() == 'application/pdf') {
                            // Generate a unique file name
                            $file_extension = $file->getClientOriginalExtension();
                            $file_name = time() . '_' . $index . '.' . $file_extension;

                            // Store the PDF file in the 'public/documents' directory
                            $file_path = $file->storeAs('documents/opportunities', $file_name, 'public');

                            // Add the file path to the array
                            $documents[] = $file_path;
                        }
                    }

                        // Assign the array of PDF file paths to the model attribute
                        $opportunity->documents = $documents;
                    }


            $opportunity->save();
                    if ($request->ajax()) {
                        // Return JSON response with opportunities information
                        return response()->json([
                            'message' => 'Opportunity has been created successfully',
                            'opportunities' => $opportunities,
                        ], 200);
                    } else {
                        // Redirect back with a success message
                        return redirect()->route('index.opportunitiess')->with('success', 'Opportunity has been created successfully');
                    }
                }
            } catch (Exception $e) {
                // Handle exceptions as needed...

                // Check if the request is an AJAX request
                if ($request->ajax()) {
                    return response()->json(['error' => 'An error occurred.'], 500);
                } else {
                    // Redirect back with an error message
                    return redirect()->route('index.opportunitiess')->with('error', 'An error occurred.');
                }
            }
    }


    public function edit($id)
    {
        session(['title' => 'Edit Opportunity']);

        $opportunity = Opportunity::find($id);

        return view('opportunities.create', compact('opportunity'));
    }


    public function confirmDelete($id){
        session(['title' => 'Confirm Delete']);
        $opportunity = Opportunity::find($id);
        return view('opportunities.confirm_delete', compact('opportunity'));
    }

    public function delete(Request $request){
        $opportunity = Opportunity::find($request->id);

        $opportunity->delete();

        return redirect()->route('index.opportunities');
    }


    public function getOpportunities()
    {
        $opportunities = Opportunity::get();
        return response()->json($opportunities);
    }

    public function search(Request $request)
    {
        $builder = Opportunity::query()->with('opportunity_name');
        $builder->where('opportunity_name', '%' . $request->input('query') . '%');
        return response()->json($builder->get());
    }

    public function getOpportunity($id)
    {
        // Get a single category
        $opportunity = Opportunity::find($id);
        return response()->json($opportunity);
    }


    public function show($category_id)
    {
        $opportunity = Opportunity::find($category_id);

        return view('opportunities.show', compact('opportunity'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'opportunity_name' => 'required',
            'phone' => 'required',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $opportunity = Category::find($id);
        $opportunity->opportunity_name = is_null($request->opportunity_name) ? $opportunity->opportunity_name : $request->opportunity_name;
        $opportunity->phone = is_null($request->phone) ? $opportunity->phone : $request->phone;

        if ($image = $request->file('profile_pic')) {
            $destinationPath = 'profile_pic/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $opportunity['profile_pic'] = "$profileImage";
        }

        $opportunity->save();

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunity Has Been updated successfully');
    }

    public function destroy(opportunity $opportunity)
    {
        $opportunity->delete();
        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunity has been deleted successfully');
    }
}
