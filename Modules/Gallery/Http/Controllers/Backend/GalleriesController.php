<?php

namespace Modules\Gallery\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class GalleriesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Galleries';

        // module name
        $this->module_name = 'galleries';

        // directory path of the module
        $this->module_path = 'gallery::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-images';

        // module model name, path
        $this->module_model = "Modules\Gallery\Models\Gallery";
    }

    /**
     * Display a listing of galleries
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_action = 'List';

        $galleries = $this->module_model::with('creator', 'images')->paginate(20);

        return view("{$this->module_path}.{$module_name}.index", compact('module_title', 'module_name', 'module_icon', 'module_action', 'galleries'));
    }

    public function index_list(\Illuminate\Http\Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $query_data = $this->module_model::where('name', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get();

        $data = [];
        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->name,
            ];
        }

        return response()->json($data);
    }

    public function index_data()
    {
        return response()->json(['data' => []]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Create';

        return view("{$this->module_path}.{$module_name}.create", compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action'));
    }

    /**
     * Store a new gallery
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $gallery = $this->module_model::create($validated);

        flash("New Gallery '{$gallery->name}' created successfully")->success()->important();

        return redirect()->route('backend.galleries.show', $gallery->id);
    }

    /**
     * Show gallery details
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Show';
        $module_name_singular = 'gallery';

        $gallery = $this->module_model::with('images')->findOrFail($id);

        return view("{$this->module_path}.{$module_name}.show", compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'gallery'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Edit';
        $module_name_singular = 'gallery';

        $gallery = $this->module_model::findOrFail($id);

        return view("{$this->module_path}.{$module_name}.edit", compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'gallery'));
    }

    /**
     * Update gallery
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $gallery = $this->module_model::findOrFail($id);
        
        $validated['updated_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $gallery->update($validated);

        flash("Gallery '{$gallery->name}' updated successfully")->success()->important();

        return redirect()->route('backend.galleries.show', $gallery->id);
    }

    /**
     * Delete gallery
     */
    public function destroy($id)
    {
        $gallery = $this->module_model::findOrFail($id);
        $gallery->delete();

        flash("Gallery deleted successfully")->success()->important();

        return redirect()->route('backend.galleries.index');
    }

    public function trashed()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_action = 'Trash List';

        $galleries = $this->module_model::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(20);

        return view("{$this->module_path}.{$module_name}.trash", compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'galleries'));
    }

    public function restore($id)
    {
        $gallery = $this->module_model::withTrashed()->find($id);
        $gallery->restore();

        flash("Gallery restored successfully")->success()->important();

        return redirect()->route('backend.galleries.index');
    }
}
