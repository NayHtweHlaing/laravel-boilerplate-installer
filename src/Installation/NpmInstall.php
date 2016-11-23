<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class NpmInstall
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class NpmInstall
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * NpmInstall constructor.
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
		if (! $this->command->output->confirm('Would you like to install the NPM dependencies?', true)) {
			return;
		}

		$this->command->output->writeln('<info>Installing NPM Dependencies (Few Minutes)...</info>');

		$process = (new Process('npm set progress=false && npm install', $this->command->path))->setTimeout(null);

		if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
			$process->setTty(true);
		}

		$process->run(function ($type, $line) {
			$this->command->output->write($line);
		});

		if (!$process->isSuccessful()) {
			throw new ProcessFailedException($process);
		}

		$this->command->npm_installed = true;
		$this->command->output->writeln('<info>NPM Dependencies Installed!</info>');
	}
}