<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class CleanTemplate extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'clean:template {--f|force}';

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
    public function handle()
    {
        if ($this->option('force')) {
            $db_reset = 'yes';
            $migrations = 'yes';
            $seeds = 'yes';
            $route = 'yes';
        } else {
            $db_reset = $this->confirm('Reset database migrations?', true);
            $migrations = $this->confirm('Remove example database migration?',
                true);
            $seeds = $this->confirm('Remove example database seed?', true);
            $route = $this->confirm('Remove example route?', true);
        }
        $namespace = $this->ask('Application namespace?', 'App');
        if ($db_reset) {
            $this->info('Resetting database migrations...');
            $db_reset_process = new Process('docker-compose run --rm fpm php artisan migrate:reset');
            $db_reset_process->run();
        }
        if ($migrations) {
            $filename = database_path('migrations/2016_03_16_122149_create_quotes_table.php');
            if ($this->deleteFile($filename, 'Example migration')) {
                $this->info('Removing example database migration...');
            }
        }
        if ($seeds) {
            $filename = database_path('seeds/QuotesTableSeeder.php');
            if ($this->deleteFile($filename, 'Example seed')) {
                $this->info('Removing example database seed...');
            }

            $this->info('Altering DatabaseSeeder file.');
            $system = new Filesystem();
            $blacklist = "QuotesTableSeeder";
            $fname = database_path('seeds/DatabaseSeeder.php');
            $rows = explode("\n", $system->get($fname));

            foreach ($rows as $key => $row) {
                if (preg_match("/($blacklist)/", $row)) {
                    unset($rows[$key]);
                }
            }

            file_put_contents($fname, implode("\n", $rows));
        }
    }

    private function deleteFile($filename, $type)
    {
        $system = new Filesystem();
        if ($system->exists($filename)) {
            $system->delete($filename);
        } else {
            $this->warn("$type already deleted.");
            return false;
        }
        return true;
    }
}