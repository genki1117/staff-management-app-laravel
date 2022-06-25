<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Department;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::select('id', 'name', 'age', 'email', 'department_id', 'file_path')->get();

        return view('admin.owners_content.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.owners_content.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        $image_file = $request->file('image');
        $file_path = '/app/public/';
        $file_name_store = ImageService::upload($image_file, $file_path);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'department_id' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Owner::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'file_path' => $file_name_store,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.owners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owner = Owner::findOrFail($id);
        return view('admin.owners_content.show', compact('owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        $departments = Department::all();
        return view('admin.owners_content.edit', compact('owner', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UploadImageRequest $request, $id)
    {
        $owner = Owner::findOrFail($id);
        $image_file = $request->file('image');
        $file_path = '/app/public/';
        $file_name_store = ImageService::upload($image_file, $file_path);

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required',
            'email' => 'required|email|unique:owners,email,' . $owner->id,
            'department_id' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $owner->name = $request->name;
        $owner->age = $request->age;
        $owner->email = $request->email;
        $owner->department_id = $request->department_id;
        $owner->file_path = $file_name_store;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()->route('admin.owners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Owner::findOrFail($id)->delete();
        return redirect()->route('admin.owners.index');
    }

    public function expiredOwnersIndex()
    {
        $expired_owners = Owner::onlyTrashed()->get();
        return view('admin.owners_content.expired_owners_index', compact('expired_owners'));
    }

    public function expiredOwnersRestore()
    {
        Owner::onlyTrashed()->restore();
        return redirect()->route('admin.owners.index');
    }

    public function expiredOwnersDestroy()
    {
        Owner::onlyTrashed()->forceDelete();
        return redirect()->route('admin.owners.index');
    }
}
