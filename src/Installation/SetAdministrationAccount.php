<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

/**
 * Class SetAdministratorAccount
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class SetAdministratorAccount
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

	}
}