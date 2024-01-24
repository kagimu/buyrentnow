<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Partner;

class PartnerController extends Controller
{
     public function index()
    {
        session(['title' => 'Partners']);
        $partners = Partner::get();
        return view('partners.index', compact('partners'));
    }

    public function create()
    {
        session(['title' => 'Create Partner']);

        $partner = new Partner();

        return view('partners.create', compact('partner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'partner_name' => 'required',
            'desc' => 'required',
            'partner_category' => 'required',
            
        ]);


        if ($request->partner_id) {
            $partner = Partner::find($request->partner_id);
            $message = "Partner has been updated successfully";
        } else {
            $partner = new Partner();
            $partner->partner_name = str_replace(' ', '', strtoupper($request->partner_name));
            $message = "Partner has been added successfully";

        }
        $partner->partner_name = $request->partner_name;
        $partner->desc = $request->desc;
        $partner->partner_category = $request->partner_category;
        

       if ($request->hasFile('cover_pic')) {
            $imageName = time() . "." . $request->cover_pic->extension();
            $request->cover_pic->storeAs('public/partners', $imageName);
            $partner->cover_pic = url(Storage::url('partners/' . $imageName));
        }

        if ($request->hasFile('programs_supported_images')) {
            $programs_supported_images = [];
            foreach ($request->file('programs_supported_images') as $index => $file) {
                $file_extension = $file->getClientOriginalExtension();
                $file_name = time() . '_' . $index . '.' . $file_extension;
                $file_path = $file->storeAs('images/programs', $file_name, 'public');
                array_push($programs_supported_images, $file_path);
            }
            $partner->programs_supported_images = $programs_supported_images;
        }


        $partner->save();

        return redirect()->route('index.partners')
            ->with('message', $message);
    }


    public function edit($id)
    {
        session(['title' => 'Edit Partner']);

        $partner = Partner::find($id);

        return view('partners.create', compact('partner'));
    }


    public function confirmDelete($id){
        session(['title' => 'Confirm Delete']);
        $partner = Partner::find($id);
        return view('partners.confirm_delete', compact('partner'));
    }

    public function delete(Request $request){
        $partner = Partner::find($request->id);

        $partner->delete();

        return redirect()->route('index.partners');
    }


    public function getPartners()
    {
        $partners = Partner::get();
        return response()->json($partners);
    }

    public function search(Request $request)
    {
        $builder = Partner::query()->with('partner_name');
        $builder->where('partner_name', '%' . $request->input('query') . '%');
        return response()->json($builder->get());
    }

    public function getPartner($id)
    {
        // Get a single category
        $partner = Partner::find($id);
        return response()->json($partner);
    }


    public function show($category_id)
    {
        $partner = Partner::find($category_id);

        return view('partners.show', compact('partner'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'partner_name' => 'required',
            'phone' => 'required',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $partner = Category::find($id);
        $partner->partner_name = is_null($request->partner_name) ? $partner->partner_name : $request->partner_name;
        $partner->phone = is_null($request->phone) ? $partner->phone : $request->phone;

        if ($image = $request->file('profile_pic')) {
            $destinationPath = 'profile_pic/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $partner['profile_pic'] = "$profileImage";
        }

        $partner->save();

        return redirect()->route('partners.index')
            ->with('success', 'Partner Has Been updated successfully');
    }

    public function destroy(partner $partner)
    {
        $partner->delete();
        return redirect()->route('partners.index')
            ->with('success', 'Partner has been deleted successfully');
    }
}
