<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputOption;

class SetupDatabase extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'setup:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial Database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        if (!$this->confirmToProceed()) {
            return;
        }

        if (!$this->confirmToProceed('All database will be replace. Are you sure want do it?', true)) {
            return;
        }

//        $tables = [];
//        $dropList = implode(', ', $tables);
//
//        DB::beginTransaction();
//        //turn off referential integrity
//        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
//        DB::statement("DROP TABLE {$dropList}");
//        //turn referential integrity back on
//        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
//        DB::commit();

        $this->info('>> Destroy DB ...');
        $this->callSilent('migrate:reset', ['--force' => true]);

        $this->info('>> Recreate DB ...');
        $this->callSilent('migrate', ['--force' => true]);

        $this->info('>> Seed DB ...' . PHP_EOL);
        $this->callSilent('cache:clear');
        $this->callSilent('db:seed', ['--force' => true]);

        $this->info('>> Make administrator account');
        $this->call('make:admin');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}
