<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Console\Question\Question;

/**
 * Class SetAdministratorAccount
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class SetAdministratorAccount
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * @var string
	 */
	protected $seeder;

	/**
	 * CopyEnv constructor.
	 * @param NewCommand $command
	 */
	public function __construct(NewCommand $command)
	{
		$this->command = $command;
		$this->seeder = $this->command->path . '/database/seeds/Access/UserTableSeeder.php';
	}

	/**
	 * Run the installation helper.
	 *
	 * @return void
	 */
	public function install()
	{
		if ($this->command->migrations_run) {
			if (!$this->command->output->confirm('Would you like to set the credentials to the administrator account?', true)) {
				return;
			}

			$helper = $this->command->getHelper('question');

			$question = new Question('Name (Admin Istrator):', 'Admin Istrator');
			$name = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setName($name);

			$question = new Question('E-mail (admin@admin.com):', 'admin@admin.com');
			$email = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setEmail($email);

			$question = new Question('Password (1234):', '1234');
			$password = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setPassword($password);

			$this->command->output->writeln('<info>Administrator Account Information Set!</info>');
		}

		return;
	}

	/**
	 * @param $name
	 */
	private function setName($name) {
		file_put_contents($this->seeder, str_replace(
			"'name'              => 'Admin Istrator',",
			"'name'              => '".$name."',",
			file_get_contents($this->seeder)
		));
	}

	/**
	 * @param $email
	 */
	private function setEmail($email) {
		file_put_contents($this->seeder, str_replace(
			"'email'             => 'admin@admin.com',",
			"'email'             => '".$email."',",
			file_get_contents($this->seeder)
		));
	}

	/**
	 * @param $password
	 */
	private function setPassword($password) {
		file_put_contents($this->seeder, str_replace(
			"'password'          => bcrypt('1234'),",
			"'password'          => bcrypt('".$password."'),",
			file_get_contents($this->seeder)
		));
	}
}