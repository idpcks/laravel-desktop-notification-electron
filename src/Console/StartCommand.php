<?php

namespace LaravelDesktopNotifications\Console;

use Illuminate\Console\Command;

class StartCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'desktop-notifications:start 
                            {--background : Start in background mode}
                            {--dev : Start in development mode}';

    /**
     * The console command description.
     */
    protected $description = 'Start the Electron app for desktop notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $electronPath = base_path('electron-app');
        $packageJson = $electronPath . '/package.json';

        if (!file_exists($packageJson)) {
            $this->error('❌ Electron app not found. Please run: php artisan desktop-notifications:install');
            return Command::FAILURE;
        }

        $this->info('🚀 Starting Electron app...');
        $this->newLine();

        $currentDir = getcwd();
        chdir($electronPath);

        // Check if npm is available
        $npmCheck = shell_exec('npm --version 2>&1');
        if (strpos($npmCheck, 'npm') === false) {
            $this->error('❌ npm not found. Please install Node.js and npm first.');
            $this->line('Download from: https://nodejs.org/');
            chdir($currentDir);
            return Command::FAILURE;
        }

        // Check if dependencies are installed
        if (!file_exists($electronPath . '/node_modules')) {
            $this->warn('⚠️  Dependencies not installed. Installing now...');
            $this->line('Running: npm install');
            $output = shell_exec('npm install 2>&1');
            $this->line($output);
        }

        // Start the app
        $command = 'npm start';
        if ($this->option('dev')) {
            $command = 'npm run dev';
        }

        if ($this->option('background')) {
            $this->info('Starting Electron app in background...');
            
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                // Windows
                pclose(popen("start /B " . $command, "r"));
            } else {
                // Linux/macOS
                shell_exec($command . ' > /dev/null 2>&1 &');
            }
            
            $this->info('✅ Electron app started in background');
            $this->line('You can now send notifications from your Laravel app');
        } else {
            $this->info('Starting Electron app...');
            $this->line('Press Ctrl+C to stop');
            $this->newLine();
            
            // Run the command
            passthru($command);
        }

        chdir($currentDir);
        return Command::SUCCESS;
    }
} 