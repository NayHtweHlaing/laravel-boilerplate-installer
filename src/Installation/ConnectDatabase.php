<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

/**
 * Class ConnectDatabase
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class ConnectDatabase
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