<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class GenerateKey
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class GenerateKey
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * GenerateKey constructor.
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
		if ($this->command->depencies_installed) {
			$this->command->output->writeln('<info>Setting Application Key...</info>');

			$process = (new Process('php artisan key:generate', $this->command->path))->setTimeout(null);

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