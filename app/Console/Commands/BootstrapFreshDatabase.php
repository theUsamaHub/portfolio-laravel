<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class BootstrapFreshDatabase extends Command
{
    protected $signature = 'app:bootstrap-db';
    protected $description = 'Create infrastructure tables (users, sessions, cache, jobs) so the app can boot on a fresh database';

    public function handle(): int
    {
        $tables = [
            'users', 'password_reset_tokens', 'sessions',
            'cache', 'cache_locks',
            'jobs', 'job_batches', 'failed_jobs',
            'migrations',
        ];

        $created = 0;
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                $this->createTable($table);
                $this->info("  Created: {$table}");
                $created++;
            } else {
                $this->line("  Exists:  {$table}");
            }
        }

        if ($created > 0) {
            $this->newLine();
            $this->info("Created {$created} infrastructure table(s).");
        }

        $this->newLine();
        $this->info("Now run: php artisan migrate");
        $this->info("Then seed with: php artisan db:seed");

        return Command::SUCCESS;
    }

    private function createTable(string $table): void
    {
        match ($table) {
            'users' => Schema::create('users', function (Blueprint $t) {
                $t->id();
                $t->string('name');
                $t->string('email')->unique();
                $t->timestamp('email_verified_at')->nullable();
                $t->string('password');
                $t->rememberToken();
                $t->timestamps();
            }),
            'password_reset_tokens' => Schema::create('password_reset_tokens', function (Blueprint $t) {
                $t->string('email')->primary();
                $t->string('token');
                $t->timestamp('created_at')->nullable();
            }),
            'sessions' => Schema::create('sessions', function (Blueprint $t) {
                $t->string('id')->primary();
                $t->foreignId('user_id')->nullable()->index();
                $t->string('ip_address', 45)->nullable();
                $t->text('user_agent')->nullable();
                $t->longText('payload');
                $t->integer('last_activity')->index();
            }),
            'cache' => Schema::create('cache', function (Blueprint $t) {
                $t->string('key')->primary();
                $t->mediumText('value');
                $t->bigInteger('expiration')->index();
            }),
            'cache_locks' => Schema::create('cache_locks', function (Blueprint $t) {
                $t->string('key')->primary();
                $t->string('owner');
                $t->bigInteger('expiration')->index();
            }),
            'jobs' => Schema::create('jobs', function (Blueprint $t) {
                $t->id();
                $t->string('queue')->index();
                $t->longText('payload');
                $t->unsignedSmallInteger('attempts');
                $t->unsignedInteger('reserved_at')->nullable();
                $t->unsignedInteger('available_at');
                $t->unsignedInteger('created_at');
            }),
            'job_batches' => Schema::create('job_batches', function (Blueprint $t) {
                $t->string('id')->primary();
                $t->string('name');
                $t->integer('total_jobs');
                $t->integer('pending_jobs');
                $t->integer('failed_jobs');
                $t->longText('failed_job_ids');
                $t->mediumText('options')->nullable();
                $t->integer('cancelled_at')->nullable();
                $t->integer('created_at');
                $t->integer('finished_at')->nullable();
            }),
            'failed_jobs' => Schema::create('failed_jobs', function (Blueprint $t) {
                $t->id();
                $t->string('uuid')->unique();
                $t->string('connection');
                $t->string('queue');
                $t->longText('payload');
                $t->longText('exception');
                $t->timestamp('failed_at')->useCurrent();
                $t->index(['connection', 'queue', 'failed_at']);
            }),
            'migrations' => Schema::create('migrations', function (Blueprint $t) {
                $t->id();
                $t->string('migration');
                $t->integer('batch');
            }),
        };
    }
}
