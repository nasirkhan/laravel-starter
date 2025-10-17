<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

trait AutoDiscoverModuleSeeders
{
    /**
     * Automatically discover and call module seeders.
     */
    protected function callModuleSeeders()
    {
        $modulesStatusFile = base_path('modules_statuses.json');

        if (! File::exists($modulesStatusFile)) {
            return;
        }

        $modulesStatus = json_decode(File::get($modulesStatusFile), true);

        if (! is_array($modulesStatus)) {
            return;
        }

        foreach ($modulesStatus as $moduleName => $isEnabled) {
            if (! $isEnabled) {
                continue; // Skip disabled modules
            }

            $moduleNameLower = strtolower($moduleName);
            $seederBinding = $moduleNameLower.'.database.seeder';

            if (App::bound($seederBinding)) {
                try {
                    $seederClass = App::make($seederBinding);
                    $this->call($seederClass);
                } catch (\Exception $e) {
                    $this->command->warn("Failed to seed module '{$moduleName}': ".$e->getMessage());
                    // Continue with other modules
                }
            }
        }
    }
}
