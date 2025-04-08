<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:comments {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all comments from a PHP file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the file path from the argument
        $filePath = $this->argument('file');

        // Check if the file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1;
        }

        // Read the file content
        $content = file_get_contents($filePath);

        // Regular expression to remove PHP comments
        $contentWithoutComments = preg_replace(
            [
                '/\/\*[\s\S]*?\*\//', // Matches block comments
                '/\/\/.*$/m',         // Matches single-line comments
                '/#.*$/m',            // Matches shell-style comments
            ],
            '',
            $content
        );

        // Overwrite the file with the updated content
        file_put_contents($filePath, $contentWithoutComments);

        $this->info("Comments removed successfully from: $filePath");

        return 0;
    }
}
