<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

class ProgramController extends Controller
{
    public function index()
    {
        session(['title' => 'Programs']);
        $programs = Program::get();

        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        session(['title' => 'Create Program']);

        $program = new Program();

        return view('programs.create', compact('program'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'desc' => 'required',
        'cover_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // Add validation rules for other fields like logo if needed
    ]);

    try {
        $program = new Program();
        $program->title = $request->title;
        $program->desc = $request->desc;

        if ($request->hasFile('cover_pic')) {
            $imageName = time().'.'.$request->cover_pic->extension();
            $request->cover_pic->storeAs('programs/coverPics', $imageName);
            $program->cover_pic = url(Storage::url('coverPics/'.$imageName));
        }

        if ($request->hasFile('logo')) {
            $imageName = time().'.'.$request->logo->extension();
            $request->logo->storeAs('programs/logo', $imageName);
            $program->logo = url(Storage::url('logo/'.$imageName));
        }

        if (is_array($request->file('gallery_images')) || is_object($request->file('gallery_images'))) {
            $imageUrls = [];
            foreach ($request->file('gallery_images') as $image) {
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->storeAs('programs/gallery_images', $imageName);
                $url = Storage::url('gallery_images/'.$imageName);
                array_push($imageUrls, $url);
            }
            $program->gallery_images = $imageUrls;
        }

        $program->save();

        if ($request->ajax()) {
            // Return JSON response with programs information
            return response()->json([
                'message' => 'Program has been created successfully',
                'program' => $program,
            ], 200);
        } else {
            // Redirect back with a success message
            return redirect()->route('index.programs')->with('success', 'Program has been created successfully');
        }
    } catch (Exception $e) {
        // Handle exceptions as needed...

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json(['error' => 'An error occurred.'], 500);
        } else {
            // Redirect back with an error message
            return redirect()->route('index.programs')->with('error', 'An error occurred.');
        }
    }
}


    public function edit($id)
    {
        session(['title' => 'Edit Program']);

        $program = Program::find($id);

        return view('programs.create', compact('program'));
    }

    public function confirmDelete($id)
    {
        session(['title' => 'Confirm Delete']);
        $program = Program::find($id);

        return view('programs.confirm_delete', compact('program'));
    }

    public function delete(Request $request)
    {
        $program = Program::find($request->id);

        $program->delete();

        return redirect()->route('index.programs');
    }

    public function getPrograms()
    {
        $programs = Program::get();

        return response()->json($programs);
    }

    public function search(Request $request)
    {
        $builder = Program::query()->with('program_name');
        $builder->where('program_name', '%'.$request->input('query').'%');

        return response()->json($builder->get());
    }

    public function getProgram($id)
    {
        // Get a single category
        $program = Program::find($id);

        return response()->json($program);
    }

    public function show($category_id)
    {
        $program = Program::find($category_id);

        return view('programs.show', compact('program'));

    }

  public function update(Request $request, $id)
{
    $request->validate([
        'program_name' => 'required',
        'phone' => 'required',
        'cover_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // Add validation rules for other fields like logo if needed
    ]);

    $program = Program::find($id);
    $program->program_name = is_null($request->program_name) ? $program->program_name : $request->program_name;
    $program->phone = is_null($request->phone) ? $program->phone : $request->phone;

    if ($image = $request->file('cover_pic')) {
        $destinationPath = 'profile_pic/';
        $profileImage = date('YmdHis').'.'.$image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $program['cover_pic'] = "$profileImage";
    }

    $program->save();

    return redirect()->route('programs.index')
        ->with('success', 'Program Has Been updated successfully');
}


    public function destroy(program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program has been deleted successfully');
    }
}
