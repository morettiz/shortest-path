<?php

namespace App\Console\Commands;

use App\Domain\Service\ShortestPathService;
use Illuminate\Console\Command;

class ShortestPathCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:shortest-path {file=assets/input.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to find the least cost path among nodes from point A to B';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $file = $this->argument('file');

            $route = $this->ask('Please enter the route');

            $service = new ShortestPathService($file, $route);

            $bestRoute = $service->handle();

            $this->info($bestRoute);

        } catch (\ErrorException $e) {
            $this->error($e->getMessage());
            return;
        }
    }
}
