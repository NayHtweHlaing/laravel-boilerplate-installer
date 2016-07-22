<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Console\Question\Question;

/**
 * Class ConnectDatabase
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class ConnectDatabase
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * @var
	 */
	protected $env;

	/**
	 * CopyEnv constructor.
	 * @param NewCommand $command
	 */
	public function __construct(NewCommand $command)
	{
		$this->command = $command;
		$this->env = $this->command->path . '/.env';
	}

	/**
	 * Run the installation helper.
	 *
	 * @return void
	 */
	public function install()
	{
		if ($this->command->dependencies_installed) {
			if (!$this->command->output->confirm('Would you like set database credentials?', true)) {
				return;
			}

			$helper = $this->command->getHelper('question');

			$question = new Question('Connection (mysql):', 'mysql');
			$connection = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setConnection($connection);

			$question = new Question('Host (127.0.0.1):', '127.0.0.1');
			$host = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setHost($host);

			$question = new Question('Port (3306):', '3306');
			$port = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setPort($port);

			$question = new Question('Database Name (homestead):', 'homestead');
			$database = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setDatabase($database);

			$question = new Question('Username (homestead):', 'homestead');
			$username = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setUsername($username);

			$question = new Question('Password (secret):', 'secret');
			$password = $helper->ask($this->command->input, $this->command->output, $question);
			$this->setPassword($password);

			$this->command->database_set = true;
			$this->command->output->writeln('<info>Database Credentials Set!</info>');
		}

		return;
	}

	/**
	 * @param $connection
	 */
	private function setConnection($connection) {
		file_put_contents($this->env, str_replace(
			'DB_CONNECTION=mysql',
			'DB_CONNECTION='.$connection,
			file_get_contents($this->env)
		));
	}

	/**
	 * @param $host
	 */
	private function setHost($host) {
		file_put_contents($this->env, str_replace(
			'DB_HOST=127.0.0.1',
			'DB_HOST='.$host,
			file_get_contents($this->env)
		));
	}

	/**
	 * @param $port
	 */
	private function setPort($port) {
		file_put_contents($this->env, str_replace(
			'DB_PORT=3306',
			'DB_PORT='.$port,
			file_get_contents($this->env)
		));
	}

	/**
	 * @param $database
	 */
	private function setDatabase($database) {
		file_put_contents($this->env, str_replace(
			'DB_DATABASE=homestead',
			'DB_DATABASE='.$database,
			file_get_contents($this->env)
		));
	}

	/**
	 * @param $username
	 */
	private function setUsername($username) {
		file_put_contents($this->env, str_replace(
			'DB_USERNAME=homestead',
			'DB_USERNAME='.$username,
			file_get_contents($this->env)
		));
	}

	/**
	 * @param $password
	 */
	private function setPassword($password) {
		file_put_contents($this->env, str_replace(
			'DB_PASSWORD=secret',
			'DB_PASSWORD='.$password,
			file_get_contents($this->env)
		));
	}
}