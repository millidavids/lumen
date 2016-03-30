<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use PhpParser\Node\Scalar\MagicConst\File;
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
    protected $description = 'Cleans the example files out of the project';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('force')) {
            $dbReset = true;
            $migrations = true;
            $seeds = true;
            $route = true;
            $test = true;
        } else {
            $dbReset = $this->confirm('Reset database migrations?', true);
            $migrations = $this->confirm('Remove example database migration?',
                true);
            $seeds = $this->confirm('Remove example database seed?', true);
            $route = $this->confirm('Remove example route?', true);
            $test = $this->confirm('Remove example test?', true);
        }

        if ($dbReset) {
            $this->info('Resetting database migrations...');
            $dbResetProcess = new Process('docker-compose run --rm fpm php artisan migrate:reset');
            $dbResetProcess->run();
        }

        if ($migrations) {
            $migrationFilename = database_path('migrations/2016_03_16_122149_create_quotes_table.php');
            if ($this->deleteFile($migrationFilename, 'Example migration')) {
                $this->info('Removing example database migration...');
            }
        }

        if ($seeds) {
            $seedFilename = database_path('seeds/QuotesTableSeeder.php');
            if ($this->deleteFile($seedFilename, 'Example seed')) {
                $this->info('Removing example database seed...');
            }

            $this->info('Altering DatabaseSeeder file...');
            $seederFilename = database_path('seeds/DatabaseSeeder.php');
            $this->removeLineContaining($seederFilename, 'QuotesTableSeeder');
        }

        if ($route) {
            $this->info('Removing example route...');
            $this->removeLineContaining(base_path('app/Http/routes.php'),
                'quotes');

        }

        if ($test) {
            $routeFilename = base_path('tests/ExampleTest.php');
            if ($this->deleteFile($routeFilename, 'Example test')) {
                $this->info('Removing example test...');
            }
        }

        $this->info('Reverting readme...');
        $system = new Filesystem();
        $filename = base_path('readme.md');
        if ($system->exists($filename)) {
            $system->put($filename, '');
        }

        $this->info('Removing Travis CI notifications...');
        $this->removeTravisNotification();

        $this->info('Removing this command...');
        $this->removeLineContaining(base_path('app/Console/kernel.php'), 'CleanTemplate');
        $this->deleteFile(base_path('app/Console/Commands/CleanTemplate.php'));
    }

    private function deleteFile($filename, $type=null)
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

    private function removeLineContaining($filename, $blacklist)
    {
        $system = new Filesystem();
        $rows = explode("\n", $system->get($filename));

        foreach ($rows as $key => $row) {
            if (preg_match("/($blacklist)/", $row)) {
                unset($rows[$key]);
            }
        }

        $system->put($filename, implode("\n", $rows));
    }

    private function removeTravisNotification()
    {
        $system = new Filesystem();
        $filename = base_path('.travis.yml');
        $blacklist = 'notifications';
        $rows = explode("\n", $system->get($filename));

        $section = false;
        foreach ($rows as $key => $row) {
            if ($section) {
                if (!empty($row) && preg_match('/\s/', $row[0])) {
                    unset($rows[$key]);
                } else {
                    $section = false;
                }
            } elseif (preg_match("/($blacklist)/", $row)) {
                $section = true;
                unset($rows[$key]);
            }
        }

        $system->put($filename, implode("\n", $rows));
    }
}