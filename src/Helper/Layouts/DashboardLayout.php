<?php

namespace EslamDDD\SkelotonPackage\Helper\Layouts;

use EslamDDD\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;

class DashboardLayout extends Layout
{
    /**
     * Specify the directory name of the layout-view
     *
     * @param  string  $viewName
     */
    protected $viewName = 'dashboard';

    /**
     * Create layout and files for the current template
     */
    public function build(): bool
    {
        $dir = public_path('layout-dist');

        if (File::isDirectory($dir)) {
            File::deleteDirectory($dir);
        }

        File::makeDirectory($dir);

        File::copyDirectory(Path::build(Path::package(), 'views', 'dashboard', 'dist'), $dir);

        File::copyDirectory(Path::build(Path::package(), 'views', 'dashboard', 'layout'), resource_path('views/backend'));

        return true;
    }
}
