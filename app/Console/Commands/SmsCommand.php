<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:command {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//       echo User::where('email',$this->argument('email'))->first()->phone_number;

        print_r($this->argument('email'));

//        $defaultIndex = 0;
//        $parent = $this->choice('Who are you?', ['Daddy', 'Mommy'], $defaultIndex);
//        echo $parent;

//        $this->info('This message will be shown in green');
//        $this->error('This message will be shown in red');
//        $this->line('This message will be shown as a plain text');
  }

}
