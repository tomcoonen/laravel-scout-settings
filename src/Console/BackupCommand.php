<?php

namespace Algolia\Settings\Console;

use Illuminate\Support\Facades\File;

class BackupCommand extends AlgoliaCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'algolia:settings:backup {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Back up all settings of the given model into the a json file in your project';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $class = $this->argument('model');

        $indexName = (new $class)->searchableAs();

        $index = $this->getIndex($indexName);

        File::put(
            resource_path('settings/'.$indexName.'json'),
            json_encode($index->getSettings(), JSON_PRETTY_PRINT)
        );

        $this->info('All settings for ['.$class.'] index have been backed up.');
    }
}
