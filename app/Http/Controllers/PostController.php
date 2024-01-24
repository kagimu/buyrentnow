<?php

namespace App\Http\Controllers;

use App\Helpers\FCM;
use App\Helpers\Utils;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

class PostController extends Controller
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
        session(['title' => 'Blogs & News']);
        $posts = Post::withCount('comments')->orderBy('id', 'desc')->get();

        return view('posts.index', compact('posts'));
    }

    public function getPosts()
    {
        // Get all posts
        $posts = Post::with('user')->withCount('comments')->orderBy('created_at', 'desc')->take(15)->get();

        return response()->json($posts);
    }

    public function getPostsByCategory(Request $request)
    {

        $posts = Post::with('user')->withCount('comments')->orderBy('created_at')->take(15)->get();

        return response()->json($posts);
    }

    public function getPostDetails($id)
    {
        // Get a single post
        $post = Post::with('user', 'comments', 'comments.user', 'comments.replies', 'comments.replies.user')->withCount('comments')->find($id);

        if ($post) {
            return response()->json($post);
        } else {
            return response()->json(['error' => 'Post not found'], 404);
        }
    }

    public function create()
    {

        $post = new Post;

        return view('posts.create', compact('post'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'location' => 'required',
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
                    return redirect()->route('index.posts')->with('error', $message);
                }
            } else {
                // Get the authenticated user
                $user = auth()->user();

                $post = new Post();

                $post->title = $request->title;
                $post->desc = $request->desc;
                $post->location = $request->location;
                $post->tag = $request->tag;
                $post->owner = $request->input('owner');
                $post->user_id = $user->id;

                if ($request->hasFile('video')) {
                    $videoFile = $request->file('video');
                    $videoExt = $videoFile->getClientOriginalExtension();
                    $videoName = time().'_'.$videoExt;
                    $videoPath = $videoFile->storeAs('videos', $videoName, 'public');
                    $post->video = $videoPath;
                }

                if ($request->hasFile('cover_pic')) {
                    $imageFile = $request->file('cover_pic');
                    $imageExt = $imageFile->getClientOriginalExtension();
                    $imageName = time().'_'.$imageExt;
                    $imagePath = $imageFile->storeAs('images/cover_pic', $imageName, 'public');
                    $post->cover_pic = $imagePath;
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
                    $post->images = $images;
                }

                $post->save();

                // Check if the request is an AJAX request
                if ($request->ajax()) {
                    // Return JSON response with post information
                    return response()->json([
                        'message' => 'Post has been created successfully',
                        'post' => $post,
                    ], 200);
                } else {
                    // Redirect back with a success message
                    return redirect()->route('index.posts')->with('success', 'Post has been created successfully');
                }
            }
        } catch (Exception $e) {
            // Handle exceptions as needed...

            // Check if the request is an AJAX request
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred.'], 500);
            } else {
                // Redirect back with an error message
                return redirect()->route('index.posts')->with('error', 'An error occurred.');
            }
        }
    }

    public function show($id)
    {
        session(['title' => 'Show Post']);
        $post = Post::find($id);

        if (! $post) {
            // Handle the case where the post is not found
            return response()->json(['error' => 'Post not found'], 404);
        }

        $comments = Comment::where('post_id', $post->id)->get();

        return view('posts.show', compact('post', 'comments'));
    }

    public function edit($id)
    {

        $post = Post::find($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => 'required',
            'desc' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'owner' => 'required',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:pdf,jpeg,png,jpg,gif',

        ]);

        $post = Post::find($id);
        $post->name = $request->name;
        $post->desc = $request->desc;
        $post->price = $request->price;
        $post->location = $request->location;
        $post->size = $request->size;
        $post->status = $request->status;
        $post->type = $request->type;

        if ($request->hasFile('video')) {
            $videoName = time().'.'.$request->video->extension();
            $request->video->storeAs('public/videos', $videoName);
            $post->video = url(Storage::url('videos/'.$videoName));
        }

        if (is_array($request->file('images')) || is_object($request->file('images'))) {
            $imageUrls = [];
            foreach ($request->file('images') as $image) {
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $url = Storage::url('images/'.$imageName);
                array_push($imageUrls, $url);
            }
            $post->images = $imageUrls;
        }

        $post->save();

        return redirect()->route('index.posts')
            ->with('success', 'Post has been updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post has been deleted successfully');
    }

    public function search(Request $request)
    {

        $builder = Post::query()->with('user')->withCount('comments')->orderBy('created_at', 'desc');

        $builder->where('desc', 'like', '%'.$request->input('query').'%');

        return response()->json($builder->get());
    }

    public function editPost($id, Request $request)
    {
        $post = Post::findOrFail($id);

        $post->desc = $request->desc;
        $post->save();

        return response()->json($post);
    }

    public function confirmDelete($id)
    {
        session(['title' => 'Confirm Delete']);
        $post = Post::find($id);

        return view('posts.confirm_delete', compact('post'));
    }

    public function deletePost(Request $request)
    {
        $post = Post::find($request->id);

        if ($post) {
            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post has been deleted successfully');
        } else {
            return redirect()->route('posts.index')->with('error', 'Post not found');
        }

    }
}
