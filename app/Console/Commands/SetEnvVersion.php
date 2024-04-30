<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetEnvVersion extends Command
{
    public const ENV_VERSION_KEY = 'APP_VERSION';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:version:set {version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set version of the app. Maybe a clean cache is necessary.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $version = $this->argument('version');

        if (!$version) {
            return;
        }

        $contents = file_get_contents($this->laravel->environmentFilePath());

        if (!Str::contains($contents, self::ENV_VERSION_KEY)) {
            $contents .= PHP_EOL . self::ENV_VERSION_KEY . '=';
        }

        $contents = preg_replace(
            [
                $this->keyReplacementPattern(self::ENV_VERSION_KEY),
            ],
            [
                self::ENV_VERSION_KEY . '=' . $version,
            ],
            $contents
        );

        file_put_contents($this->laravel->environmentFilePath(), $contents);

        $this->info("Version successfully set in .env: $version");
    }

    /**
     * Get a regex pattern that will match env $keyName with any key.
     *
     * @param string $keyName
     * @return string
     */
    protected function keyReplacementPattern(string $keyName): string
    {
        $oldKey = $this->laravel['config']['app.version'];

        $escaped = preg_quote('=' . $oldKey, '/');

        return "/^{$keyName}{$escaped}/m";
    }
}
