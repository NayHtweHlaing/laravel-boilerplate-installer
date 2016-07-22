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
	 * CopyEnv constructor.
	 * @param NewCommand $command
	 */
	public function __construct(NewCommand $command)
	{
		$this->command = $command;
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

		$process->run(function ($type, $line) {
			$this->command->output->write($line);
		});

		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}
	}
}