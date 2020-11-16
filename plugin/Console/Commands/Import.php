<?php

namespace Visually\Console\Commands;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Visually\Client\VisuallyClient;
use Visually\WPBones\Console\Command;

class Import extends Command
{

  protected $signature = 'visually:import {--name= : Display your name}';

  protected $description = 'Description of your own bones command';

  public function handle()
  {
	  $this->info('Welcome to the importer');

	  $client = new VisuallyClient();

	  try {

		$responses = $client->extract();



	  } catch ( TransportExceptionInterface $e ) {

	  	print_r($e->getMessage());
	  	die;
	  } catch ( \Exception $e ) {
		  print_r($e->getMessage());
		  die;
	  }


  }

}
