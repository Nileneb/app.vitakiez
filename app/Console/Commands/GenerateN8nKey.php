<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateN8nKey extends Command
{
    protected $signature = 'n8n:generate-key
                            {--show : Display the key instead of modifying files}
                            {--force : Force the operation to run when in production}';

    protected $description = 'Generate a secure API key for n8n webhook authentication';

    public function handle(): int
    {
        $key = $this->generateRandomKey();

        if ($this->option('show')) {
            $this->components->info($key);
            return self::SUCCESS;
        }

        if (! $this->setKeyInEnvironmentFile($key)) {
            return self::FAILURE;
        }

        $this->components->info('N8N API key generated successfully.');
        $this->newLine();
        $this->components->twoColumnDetail('Key', $key);
        $this->newLine();
        $this->components->warn('Add this key to your n8n HTTP Request node as Bearer Token!');

        return self::SUCCESS;
    }

    protected function generateRandomKey(): string
    {
        return 'n8n_' . Str::random(64);
    }

    protected function setKeyInEnvironmentFile(string $key): bool
    {
        $envPath = base_path('.env');
        $contents = file_get_contents($envPath);

        // Check if N8N_API_KEY already exists
        if (preg_match('/^N8N_API_KEY=/m', $contents)) {
            // Update existing key
            $contents = preg_replace(
                '/^N8N_API_KEY=.*/m',
                "N8N_API_KEY={$key}",
                $contents
            );
        } else {
            // Add new key after N8N_CHAT_URL
            if (preg_match('/^N8N_CHAT_URL=.*/m', $contents)) {
                $contents = preg_replace(
                    '/(^N8N_CHAT_URL=.*$)/m',
                    "$1\nN8N_API_KEY={$key}",
                    $contents
                );
            } else {
                // Fallback: append at the end
                $contents .= "\nN8N_API_KEY={$key}\n";
            }
        }

        if (file_put_contents($envPath, $contents) === false) {
            $this->components->error('Failed to write to .env file.');
            return false;
        }

        return true;
    }
}
