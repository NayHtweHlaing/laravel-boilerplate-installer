<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class RunGulp
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class RunGulp
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * RunGulp constructor.
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
		if ($this->command->npm_installed) {
			if (! $this->command->output->confirm('Would you like to run gulp?', true)) {
				return;
			}

			$this->command->output->writeln('<info>Running Gulp...</info>');

			$process = (new Process('gulp', $this->command->path))->setTimeout(null);

			if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
				$process->setTty(true);
			}

			$process->run(function ($type, $line) {
				$this->command->output->write($line);
			});

			if (!$process->isSuccessful()) {
				throw new ProcessFailedException($process);
			}

			$this->command->output->writeln('<info>Assets Compiled & Versioned!</info>');
		}

		return;
	}
}