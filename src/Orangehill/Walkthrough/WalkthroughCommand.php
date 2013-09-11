<?php namespace Orangehill\Walkthrough;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WalkthroughCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'walkthrough';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run the Walkthrough Package hello() method from command line.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		app('walkthrough')->hello($this->argument('verb'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('verb', InputArgument::REQUIRED, 'verb'),
		);
	}

}
