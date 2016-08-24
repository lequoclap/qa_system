<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            \Log::info('Start ' . $this->signature);

            $this->doCommand();

            \Log::info('Stop ' . $this->signature);

        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    abstract function doCommand();
}
