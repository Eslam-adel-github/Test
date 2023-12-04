<?php

namespace EslamDDD\SkelotonPackage\Helper\Layouts;

use EslamDDD\SkelotonPackage\Helper\Path;

abstract class Layout
{
    /**
     * Define options to build the current AdminPannel
     *
     * @var array
     */
    protected $options;

    /**
     * Specify the directory name of the layout-view
     *
     * @param  string  $viewName
     */
    protected $viewName;

    /**
     * Define layout view-path
     *
     * @var string
     */
    protected $path;

    /**
     * Init the options attributes
     *
     * @param  array  $options optional
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;

        $this->path = Path::build(Path::package(), 'src', 'views', $this->viewName);
    }

    /**
     * Create layout and files for the current template
     */
    abstract public function build(): bool;
}
