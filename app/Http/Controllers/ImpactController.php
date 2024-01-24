<?php

namespace App\Http\Controllers;

use App\Helpers\FCM;
use App\Helpers\Utils;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Impact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

class ImpactController extends Controller
{
    protected $utils;

    protected $fcm;

    public function __construct(Utils $utils, FCM $fcm)
    {
        $this->utils = $utils;
        $this->fcm = $fcm;
    }

    public function index()
    {
        session(['title' => 'Impacts']);
        $impacts = Impact::withCount('comments')->orderBy('id', 'desc')->get();

        return view('impacts.index', compact('impacts'));
    }

    public function getImpacts()
    {
        // Get all Impacts
        $impacts = Impact::with('user')->withCount('comments')->orderBy('created_at', 'desc')->take(15)->get();

        return response()->json($impacts);
    }

    public function getImpactsByCategory(Request $request)
    {

        $impacts = Impact::with('user')->withCount('comments')->where('category_id', $request->category_name)->orderBy('created_at')->take(15)->get();

        return response()->json($impacts);
    }

    public function getImpactDetails($id)
    {
        // Get a single Impact
        $impact = Impact::with('user', 'comments', 'comments.user', 'comments.replies', 'comments.replies.user')->withCount('comments')->find($id);

        return response()->json($impact);
    }

    public function create()
    {
        $impact = new Impact;

        return view('impacts.create', compact('impact'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'location' => 'required',
            'tag' => 'required',
            'owner' => 'required',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:pdf,jpeg,png,jpg,gif',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();

                // Check if the request is an AJAX request
                if ($request->ajax()) {
                    return response()->json($message, 400);
                } else {
                    // Redirect back with an error message
                    return redirect()->route('index.impacts')->with('error', $message);
                }
            } else {
                // Get the authenticated user
                $user = auth()->user();

                $impact = new Impact();
                $impact->title = $request->title;
                $impact->desc = $request->desc;
                $impact->location = $request->location;
                $impact->tag = $request->tag;
                $impact->owner = $request->input('owner');
                $impact->user_id = $user->id; // Associate the Impact with the user

                if ($request->hasFile('video')) {
                    $videoFile = $request->file('video');
                    $videoExt = $videoFile->getClientOriginalExtension();
                    $videoName = time().'_'.$videoExt;
                    $videoPath = $videoFile->storeAs('videos', $videoName, 'public');
                    $impact->video = $videoPath;
                }

                if ($request->hasFile('cover_pic')) {
                    $imageFile = $request->file('cover_pic');
                    $imageExt = $imageFile->getClientOriginalExtension();
                    $imageName = time().'_'.$imageExt;
                    $imagePath = $imageFile->storeAs('images/profile', $imageName, 'public');
                    $impact->cover_pic = $imagePath;
                }

                // upload labtest documents
                if ($request->hasFile('images')) {
                    $images = [];
                    foreach ($request->file('images') as $index => $file) {
                        $file_extension = $file->getClientOriginalExtension();
                        $file_name = time().'_'.$index.'.'.$file_extension;
                        $file_path = $file->storeAs('images/landlords', $file_name, 'public');
                        array_push($images, $file_path);
                    }
                    $impact->images = $images;
                }

                $impact->save();

                // Check if the request is an AJAX request
                if ($request->ajax()) {
                    // Return JSON response with Impact information
                    return response()->json([
                        'message' => 'Impact has been created successfully',
                        'Impact' => $impact,
                    ], 200);
                } else {
                    // Redirect back with a success message
                    return redirect()->route('index.impacts')->with('success', 'Impact has been created successfully');
                }
            }
        } catch (Exception $e) {
            // Handle exceptions as needed...

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred.'], 500);
            } else {
                // Redirect back with an error message
                return redirect()->route('index.Impacts')->with('error', 'An error occurred.');
            }
        }
    }

    public function show($id)
    {
        session(['title' => 'Show Impact']);
        $impact = Impact::find($id);
        $comments = Comment::where('Impact_id', $impact->id)->get();

        return view('impacts.show', compact('impact', 'comments'));
    }

    public function edit($id)
    {
        $categories = Category::all();
        $impact = Impacts::find($id);

        return view('impacts.edit', compact('categories', 'Impact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'numeric|required',
            'title' => 'required',
            'desc' => 'required',
            'location' => 'required',
            'tag' => 'required',
            'owner' => 'required',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:pdf,jpeg,png,jpg,gif',

        ]);

        $impact = Impact::find($id);
        $impact->category_id = $request->category_id;
        $impact->title = $request->title;
        $impact->desc = $request->desc;
        $impact->location = $request->location;
        $impact->tag = $request->tag;
        $impact->contact = $request->contact;

        if ($request->hasFile('video')) {
            $videoName = time().'.'.$request->video->extension();
            $request->video->storeAs('public/videos', $videoName);
            $impact->video = url(Storage::url('videos/'.$videoName));
        }

        if (is_array($request->file('images')) || is_object($request->file('images'))) {
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $url = Storage::url('images/'.$imageName);
                array_push($imageUrls, $url);
            }
            $impact->images = $imageUrls;
        }

        $impact->save();

        return redirect()->route('index.Impacts')
            ->with('success', 'Impact has been updated successfully.');
    }

    public function destroy(Impact $impact)
    {
        $impact->delete();

        return redirect()->route('impacts.index')->with('success', 'Impact has been deleted successfully');
    }

    public function search(Request $request)
    {

        $builder = Impacts::query()->with('user')->withCount('comments')->orderBy('created_at', 'desc');

        $builder->where('desc', 'like', '%'.$request->input('query').'%');

        return response()->json($builder->get());
    }

    public function editImpact($id, Request $request)
    {
        $impact = Impacts::findOrFail($id);

        $impact->desc = $request->desc;
        $impact->category_id = $request->category_id;
        $impact->save();

        return response()->json($impact);
    }

    public function confirmDelete($id)
    {
        session(['title' => 'Confirm Delete']);
        $impact = Impacts::find($id);

        return view('impacts.confirm_delete', compact('Impact'));
    }

    public function deleteImpact(Request $request)
    {
        $impact = Impacts::find($request->id);

        if ($impact) {
            $impact->delete();

            return redirect()->route('impacts.index')->with('success', 'Impact has been deleted successfully');
        } else {
            return redirect()->route('impacts.index')->with('error', 'Impact not found');
        }

    }
}
