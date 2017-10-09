<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct() {

        $this->module_name = 'users';
        $this->module_path = 'users';
        $this->module_icon = 'fa fa-users';
        $this->module_title = 'Users';
        $this->module_model = 'App\Models\Access\User\User';

    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;

        $page_heading = "All Users";

        $$module_name = User::paginate(5);

        // Log::info($module_name . ' Index View');

        return view("backend.$module_name.index", compact('title', 'page_heading', 'module_icon', "module_name", "$module_name"));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_action = "Create";

        $roles = Role::lists('name', 'id');

        return view("backend.$module_name.create", compact('title', 'module_name', 'module_icon', 'module_action', 'roles'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $module_name = $this->module_name;

        $$module_name_singular = User::create($request->except('roles_list'));
        $$module_name_singular->permissions()->attach($request->input('roles_list'));

        return redirect("admin/$module_name")->with('flash_success', "$module_name added!");
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = "Details";

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.show", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'title'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = "Edit";

        $roles = Role::lists('name', 'id');

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.edit", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'title', 'roles'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $$module_name_singular = User::findOrFail($id);
        $$module_name_singular->update($request->except('roles_list'));

        if ($request->input('roles_list') === null) {
            $roles = array();
            $$module_name_singular->roles()->sync($roles);
        } else {
            $$module_name_singular->roles()->sync($request->input('roles_list'));
        }

        return redirect("admin/$module_name")->with('flash_success', "Update successful!");
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
        if (auth()->id() == $id){
            throw new GeneralException("You can not delete yourself.");
        }

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $$module_name_singular = User::withTrashed()->find($id);
        //        $$module_name_singular = $this->findOrThrowException($id);

        if ($$module_name_singular->delete()){
            Flash::success('User successfully deleted!');

            return redirect()->back();
        }

        throw new GeneralException("There was a problem updating this user. Please try again.");
    }

    public function restore($id) {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $module_action = 'Restore';

        $$module_name_singular = User::withTrashed()->find($id);
        $$module_name_singular -> restore();

        return redirect("admin/$module_name")->with('flash_success', '<i class="fa fa-check"></i> ' . ucfirst($module_name_singular) . " Restored Successfully!");

    }
}
