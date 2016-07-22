<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

/**
 * Class ComposerInstall
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class ComposerInstall
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * ComposerInstall constructor.
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
		$composer = $this->findComposer();
		$this->command->output->writeln('<info>Running Composer...</info>');

		$commands = [
			$composer.' install --no-scripts',
			$composer.' run-script post-root-package-install',
			$composer.' run-script post-install-cmd',
			$composer.' run-script post-create-project-cmd',
		];

		if ($this->command->input->getOption('no-ansi')) {
			$commands = array_map(function ($value) {
				return $value.' --no-ansi';
			}, $commands);
		}

		$process = new Process(implode(' && ', $commands), $this->command->path, null, null, null);

		if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
			$process->setTty(true);
		}

		$process->run(function ($type, $line) {
			$this->command->output->write($line);
		});

		$this->command->output->writeln('<info>Dependencies Installed!</info>');
	}

	/**
	 * @return string
	 */
	protected function findComposer()
	{
		if (file_exists(getcwd().'/composer.phar')) {
			return '"'.PHP_BINARY.'" composer.phar';
		}

		return 'composer';
	}
}