<?php
namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class CleanupCommandAll extends Command
{
    protected $signature = 'cleanup:all';

    protected $description = 'Delete all data from all tables';

    public function handle()
    {
        $tables = ['authors','books','book_index','users'];
        foreach ($tables as $table) {
            DB::table($table)->where('id', '>=', 1)->delete();
            DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = 0");
        }
        $this->info('Data cleanup completed.');
    }
}
