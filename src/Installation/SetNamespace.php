<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class SetNamespace
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class SetNamespace
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * @var string
	 */
	protected $currentRoot;

	/**
	 * CopyEnv constructor.
	 * @param NewCommand $command
	 */
	public function __construct(NewCommand $command)
	{
		$this->command = $command;
		$this->currentRoot = 'App';
	}

	/**
	 * Run the installation helper.
	 *
	 * @return void
	 */
	public function install()
	{
		if (! $this->command->output->confirm('Would you like set the application namespace?', true)) {
			return;
		}

		$helper = $this->command->getHelper('question');
		$question = new Question('Namespace (App):', 'App');
		$namespace = $helper->ask($this->command->input, $this->command->output, $question);

		$this->command->output->writeln('<info>Setting application namespace</info>...</info>');

		$process = (new Process('php artisan app:name ' . $namespace, $this->command->path))->setTimeout(null);

		if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
			$process->setTty(true);
		}

		/**
		 * Replace namespaces in known files that command doesn't hit
		 */
		$this->setConfigNamespaces($namespace);
		$this->setSeedNamespaces($namespace);

		/**
		 * Run the native command
		 */
		$process->run(function ($type, $line) {
			$this->command->output->write($line);
		});

		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}
	}

	/**
	 * @param $namespace
	 */
	private function setConfigNamespaces($namespace) {
		$search = $this->currentRoot.'\\Models';
		$replace = $namespace.'\\Models';

		$this->replaceIn($this->getConfigPath('auth'), $search, $replace);
		$this->replaceIn($this->getConfigPath('access'), $search, $replace);
		$this->replaceIn($this->getConfigPath('datatables'), $search, $replace);
		$this->replaceIn($this->getConfigPath('services'), $search, $replace);
	}

	/**
	 * @param $namespace
	 */
	private function setSeedNamespaces($namespace) {
		$search = $this->currentRoot.'\\Models';
		$replace = $namespace.'\\Models';
		$this->replaceIn($this->command->path . '/database/seeds/Access/PermissionRoleSeeder.php', $search, $replace);
	}

	/**
	 * @param $path
	 * @param $search
	 * @param $replace
	 */
	private function replaceIn($path, $search, $replace)
	{
		file_put_contents($path, str_replace(
			$search,
			$replace,
			file_get_contents($path)
		));
	}

	/**
	 * @param $name
	 * @return string
	 */
	private function getConfigPath($name)
	{
		return $this->command->path . '/config/'.$name.'.php';
	}
}