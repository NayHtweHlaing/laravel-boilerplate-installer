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

	}
}
