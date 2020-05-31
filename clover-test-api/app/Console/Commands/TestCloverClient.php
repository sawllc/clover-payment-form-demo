<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Clients\Clover\Client as CloverClient;

class TestCloverClient extends Command
{
  private $Client;

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'clover:test-client';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Artisan command line script to test & evaluate HTTP requests to the Clover REST API.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  private function searchOrders ()
  {
    $SearchResponse         =       $this->Client->orders(["query" => ["customerID" => "234028346", "debug" => 1]])->search();
    if($SearchResponse && $SearchResponse->success())
      var_dump($SearchResponse->items);
  }

  public function searchCustomers ()
  {
    $SearchResponse         =       $this->Client->customers(["query" => []])->search();
    if($SearchResponse && $SearchResponse->success())
      var_dump($SearchResponse->records);
  }

  public function getPAKMSkey ()
  {
    $SearchResponse         =       $this->Client->pakms(["query" => ["debug" => 1]])->get();
    if($SearchResponse && $SearchResponse->success())
      var_dump($SearchResponse->records);
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $this->Client           =       new CloverClient(env("CLOVER_API_TOKEN"));

    // $this->searchOrders();
    // $this->searchCustomers();
    $this->getPAKMSkey();
  }
}
