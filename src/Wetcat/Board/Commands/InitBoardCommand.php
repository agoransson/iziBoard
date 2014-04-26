<?php namespace Wetcat\Board\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InitBoardCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'izi:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize iziBoard.';

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
	 * @return mixed
	 */
	public function fire()
	{
		//Artisan::call('migrate --package=tappleby/laravel-auth-token');
		//Artisan::call('config:publish tappleby/laravel-auth-token'):

		$this->call(
        'migrate',
        array('--package' => 'cartalyst/sentry')
    );
    $this->call(
        'migrate',
        array('--package' => 'tappleby/laravel-auth-token')
    );
    $this->call(
        'migrate',
        array('--package' => 'wetcat/board')
    );
    $this->call(
        'asset:publish', array('wetcat/board')
    );
    $this->call(
        'config:publish', array('wetcat/board')
    );

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
