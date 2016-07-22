<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

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

	}
}