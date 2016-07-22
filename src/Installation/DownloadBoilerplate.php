<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use Symfony\Component\Process\Process;
use Rappasoft\BoilerplateInstaller\NewCommand;

/**
 * Class DownloadBoilerplate
 * @package Rappasoft\BoilerplateInstaller\Installation
 */
class DownloadBoilerplate
{
	/**
	 * @var NewCommand
	 */
	protected $command;

	/**
	 * DownloadBoilerplate constructor.
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