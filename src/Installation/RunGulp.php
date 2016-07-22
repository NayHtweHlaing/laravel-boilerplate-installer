<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

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

	}
}