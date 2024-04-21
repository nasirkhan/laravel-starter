<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;

class BackupController extends Controller
{
    use Authorizable;

    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Backup';

        // module name
        $this->module_name = 'backups';

        // directory path of the module
        $this->module_path = 'backups';

        // module icon
        $this->module_icon = 'fas fa-archive';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $disk = Storage::disk('local');

        $files = $disk->files(config('backup.backup.name'));

        $$module_name = [];

        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) === '.zip' && $disk->exists($f)) {
                $$module_name[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('backup.backup.name').'/', '', $f),
                    'file_size_byte' => $disk->size($f),
                    'file_size' => humanFilesize($disk->size($f)),
                    'last_modified_timestamp' => $disk->lastModified($f),
                    'date_created' => Carbon::createFromTimestamp($disk->lastModified($f))->isoFormat('llll'),
                    'date_ago' => Carbon::createFromTimestamp($disk->lastModified($f))->diffForHumans(Carbon::now()),
                ];
            }
        }

        // reverse the backups, so the newest one would be on top
        $$module_name = array_reverse($$module_name);

        return view(
            "backend.{$module_path}.backups",
            compact('module_title', 'module_name', "{$module_name}", 'module_path', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Creates a new backup for the module.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        if (demo_mode()) {
            flash('Backup Creation Skillped on Demo Mode!')->warning()->important();

            return redirect()->route("backend.{$module_path}.index");
        }

        try {
            // start the backup process
            Artisan::call('backup:run');
            $output = Artisan::output();

            // Log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n".$output);

            // return the results as a response to the ajax call
            flash('New backup created')->success()->important();

            return redirect()->back();
        } catch (Exception $e) {
            Flash::error($e->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name)
    {
        $disk = Storage::disk('local');
        $file = config('backup.backup.name').'/'.$file_name;

        if ($disk->exists($file)) {
            return Storage::download($file);
        }
        abort(404, "The backup file doesn't exist.");
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $disk = Storage::disk('local');
        $file = config('backup.backup.name').'/'.$file_name;

        if ($disk->exists($file)) {
            $disk->delete($file);

            flash("`{$file_name}` deleted successfully.")->success()->important();

            return redirect()->back();
        }
        abort(404, "The backup file doesn't exist.");
    }
}
