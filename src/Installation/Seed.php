<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class Seed
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class Seed
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
		if ($this->command->migrations_run) {
			if (!$this->command->output->confirm('Would you like to seed the database?', true)) {
				return;
			}

			$process = (new Process('php artisan db:seed', $this->command->path))->setTimeout(null);

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

		return;
	}
}