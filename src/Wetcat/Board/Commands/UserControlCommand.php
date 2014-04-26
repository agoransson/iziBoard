<?php namespace Wetcat\Board\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UserControlCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'izi:user';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Control users in iziBoard.';

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
		$action = $this->argument('action');

		switch ($action) {
			case 'admin':
				$email = $this->ask('Enter user email.');
				$password = $this->secret('Enter password.');

				$this->createAdmin($email, $password);
				break;

			case 'admin':
				$email = $this->ask('Enter user email.');
				$password = $this->secret('Enter password.');

				$this->createUser($email, $password);
				break;
			
			case 'delete':
				$email = $this->ask('Enter user email.');

				$this->deleteUser($email, $password);
				break;

			default:
				# code...
				break;
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('action', InputArgument::REQUIRED, 'Selected action [create], [delete], [admin].'),
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
			//array('email', null, InputOption::VALUE_OPTIONAL, 'User email.', null),
			//array('password', null, InputOption::VALUE_OPTIONAL, 'User password.', null),
		);
	}

	private function createAdmin($email, $password)
	{
		try
		{
		    // Create the user
		    $user = \Sentry::createUser(array(
		        'email'     => $email,
		        'password'  => $password,
		        'activated' => true,
		    ));

		    // Find the group using the group id
		    $adminGroup = \Sentry::findGroupByName('Admins');

		    // Assign the group to the user
		    $user->addGroup($adminGroup);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    echo 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    echo 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    echo 'User with this login already exists.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    echo 'Group was not found.';
		}
	}
}
