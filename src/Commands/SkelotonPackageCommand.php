<?php

namespace Eslam\SkelotonPackage\Commands;

use Illuminate\Console\Command;

class SkelotonPackageCommand extends Command
{
    public $signature = 'skeloton-package';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
