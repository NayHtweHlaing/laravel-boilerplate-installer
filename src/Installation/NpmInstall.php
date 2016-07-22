<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

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

	}
}