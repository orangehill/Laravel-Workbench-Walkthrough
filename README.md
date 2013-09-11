**Laravel Workbench Walkthrough** is a Laravel 4 workbench package generation walkthrough, used to describe package generation process in [ZgPHP Mini Conference 2013](http://2013.zgphp.org/) that happened on September 9th 2013.

This README.md file contains detailed instructions on how to create the same Workbench package yourself.

## Laravel 4 Workbench Package Generation

1) Open: `/app/config/workbench.php`

and set your name and email. This info is used later to populate the composer.json file.

2) Use Command Line Interface (CLI) to navigate to Laravel 4 root folder, and then run:

    php artisan workbench orangehill/walkthrough --resources

Note that `orangehill` represents a vendor (company name, personal name etc.), and `walkthrough` represents a package name.

3) Use your CLI to navigate to `/workbench/orangehill/walkthrough` and verify that the package structure has been created.

## Package Setup

4) Open `/app/config/app.php` to add a Service Provider to the end of the providers array:

	'providers' => array(
	  // --
	  'Orangehill\Walkthrough\WalkthroughServiceProvider',
	),

5) To create a main package class generate the file named `Walkthrough.php` inside a path `/workbench/orangehill/walkthrough/src/Orangehill/Walkthrough/` with the following code inside:

	<?php namespace Orangehill\Walkthrough;

	class Walkthrough {

		public static function hello(){
			return "What's up Zagreb?";
		}

	}

6) Register the new class with the Laravel’s IoC Container by editing Package Service Provider file `/workbench/orangehill/walkthrough/src/Orangehill/Walkthrough/WalkthroughServiceProvider.php` and make sure that the register method looks like this:

	public function register()
	{
		$this->app['walkthrough'] = $this->app->share(function($app)
		{
			return new Walkthrough;
		});
	}

**Note: If your service provider cannot be found, run the php artisan dump-autoload command from your application's root directory.**

## Package Facade Generation

Although generating a facade is not necessary, Facade allows you to do something like this:

	echo Walkthrough::hello();

7) Create a folder named `Facades` under following path `/workbench/orangehill/walkthrough/src/Orangehill/Walkthrough/`

8) Inside the `Facades` folder create a file named `Walkthrough.php` with the following content:

	<?php namespace Orangehill\Walkthrough\Facades;

	use Illuminate\Support\Facades\Facade;

	class Walkthrough extends Facade {

	  /**
	   * Get the registered name of the component.
	   *
	   * @return string
	   */
	  protected static function getFacadeAccessor() { return 'walkthrough'; }

	}

9) Add the following to the register method of your Service Provider file:

	$this->app->booting(function()
	{
	  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
	  $loader->alias('Walkthrough', 'Orangehill\Walkthrough\Facades\Walkthrough');
	});

This allows the facade to work without the adding it to the Alias array in app/config/app.php

## Browser Test

10) Edit your `/app/routes.php` file and add a route to test if a package works:

	Route::get('/hello', function(){
		echo Walkthrough::hello();
	});

If all went well you should see the `What's up Zagreb?` output in your browser after visiting the test URL.

## Adding an Artisan CLI Support

Following steps will allow yout to run your method from CLI.

11) First, let's modify the `/workbench/orangehill/walkthrough/src/Orangehill/Walkthrough/Walkthrough.php` file to accept an optional parameter and echo out a message that we can observe in our CLI:

	public static function hello($verb = 'up'){
		if (PHP_SAPI == 'cli') echo "What's $verb Zagreb?\n";
		return "What's up Zagreb?";
	}

12) Create a file `WalkthroughCommand.php` inside `/workbench/orangehill/walkthrough/src/Orangehill/Walkthrough/` folder with following content (code is pretty much self-explanatory):

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

13) Modify Service Provider file register method to include the following code:

	$this->app['command.walkthrough'] = $this->app->share(function($app)
	{
		return new WalkthroughCommand;
	});
	$this->commands('command.walkthrough');

14) Run `php artisan walkthrough cooking` from CLI in your project root folder and you should see an output `What's cooking Zagreb?`.

## About Us

Make sure to stay tuned to our [Orange Hill Blog](http://www.orangehilldev.com) for more usefull information like this.

Follow us on Facebook: [https://www.facebook.com/orangehilldev](https://www.facebook.com/orangehilldev)

Follow us on Twitter: [https://twitter.com/orangehilldev](https://twitter.com/orangehilldev)

Follow us on Linked In: [http://www.linkedin.com/company/orange-hill](http://www.linkedin.com/company/orange-hill)
