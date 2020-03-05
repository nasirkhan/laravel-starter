<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Artisan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Log;
use Storage;

class BackupController extends Controller
{
    use Authorizable;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        $files = $disk->files(str_replace(' ', '-', config('backup.backup.name')));

        $$module_name = [];

        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $$module_name[] = [
                    'file_path'               => $f,
                    'file_name'               => str_replace(str_replace(' ', '-', config('backup.backup.name')).'/', '', $f),
                    'file_size_byte'          => $disk->size($f),
                    'file_size'               => humanFilesize($disk->size($f)),
                    'last_modified_timestamp' => $disk->lastModified($f),
                    'date_created'            => Carbon::createFromTimestamp($disk->lastModified($f))->toDayDateTimeString(),
                    'date_ago'                => Carbon::createFromTimestamp($disk->lastModified($f))->diffForHumans(Carbon::now()),
                ];
            }
        }

        // reverse the backups, so the newest one would be on top
        $$module_name = array_reverse($$module_name);

        // return view("backend.backups.backups")->with(compact('backups'));
        return view(
            "backend.$module_path.backups",
            compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            // start the backup process
            Artisan::call('backup:run');
            $output = Artisan::output();

            // Log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n".$output);

            // return the results as a response to the ajax call
            flash("<i class='fas fa-check'></i> New backup created")->success()->important();

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
        $file = str_replace(' ', '-', config('backup.backup.name')).'/'.$file_name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            $fs = Storage::disk(config('backup.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);

            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                'Content-Type'        => $fs->getMimetype($file),
                'Content-Length'      => $fs->getSize($file),
                'Content-disposition' => 'attachment; filename="'.basename($file).'"',
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        if ($disk->exists(str_replace(' ', '-', config('backup.backup.name')).'/'.$file_name)) {
            $disk->delete(str_replace(' ', '-', config('backup.backup.name')).'/'.$file_name);

            return redirect()->back();
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }
}
