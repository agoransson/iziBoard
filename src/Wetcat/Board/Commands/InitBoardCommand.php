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
    $bench = $this->argument('bench');

		// Migrations
    if( !$bench ) {
      // Normal environment
      $this->call(
        'migrate',
        array('--package' => 'cartalyst/sentry')
      );
      $this->call(
        'migrate',
        array('--package' => 'wetcat/board')
      );
    } else {
      // Development environment
      $this->call(
        'migrate',
        array('--path' => 'workbench/wetcat/board/vendor/cartalyst/sentry/src/migrations/')
      );
      $this->call(
        'migrate',
        array('--bench' => 'wetcat/board')
      );
    }
    $this->info('Migrations finished!');



    // Publish assets
    if( !$bench ){
      $this->call(
        'asset:publish', array('wetcat/board')
      );
    } else {
      $this->call(
        'asset:publish', array('--bench' => 'wetcat/board')
      );
    }
    $this->info('Assets finished!');



    // Publish config
    if( !$bench ){
      $this->call(
        'config:publish', array('wetcat/board')
      );
    } else {
      // php artisan config:publish --path="workbench/wetcat/board/src/config/" wetcat/board
      /*$this->call(
        'config:publish', array('--path' => 'workbench/wetcat/board/src/config/', 'wetcat/board')
      );*/
    }
    $this->info('Configs finished!');



    // Add the admin user
    if( !$bench ) {
      /*$this->call(
      	'db:seed', array('--class' => 'UserTableSeeder')
      );*/
    } else {
      // ?
    }
    $this->info('Seeds finished!');



    // Create default admin group
    $this->createAdminGroup();
    $this->createUserGroup();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('bench', InputArgument::OPTIONAL, 'Use if workbench environment'),
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


  private function createAdminGroup()
  {
    try
    {
        // Create the group
        $group = \Sentry::createGroup(array(
            'name'        => 'Admins',
            'permissions' => array(
                'admin' => 1,
                'user' => 1,
            ),
        ));
    }
    catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
    {
        echo 'Name field is required';
    }
    catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
    {
        echo 'Group already exists';
    }
  }

  private function createUserGroup()
  {
    try
    {
        // Create the group
        $group = \Sentry::createGroup(array(
            'name'        => 'Users',
            'permissions' => array(
                'admin' => 0,
                'user' => 1,
            ),
        ));
    }
    catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
    {
        echo 'Name field is required';
    }
    catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
    {
        echo 'Group already exists';
    }
  }

}
