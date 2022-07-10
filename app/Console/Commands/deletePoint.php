<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;

class deletePoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'point:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete customer points every month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $customers =  Customer::where('points','!=','0')->get();
      foreach ($customers as $customer){
          $customer -> update(['points' => 0]);
      }

    }
}
