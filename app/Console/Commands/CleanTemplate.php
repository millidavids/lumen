<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanTemplate extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clean:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans the example files out of the project.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('it works!');
    }

}