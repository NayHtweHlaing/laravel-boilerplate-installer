<?php

namespace Rappasoft\BoilerplateInstaller\Installation;

use ZipArchive;
use GuzzleHttp\Client;
use Rappasoft\BoilerplateInstaller\NewCommand;
use Symfony\Component\Process\Exception\RuntimeException;

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
	 * @var
	 */
	protected $name;

	/**
	 * DownloadBoilerplate constructor.
	 * @param NewCommand $command
	 * @param $name
	 */
	public function __construct(NewCommand $command, $name)
	{
		$this->command = $command;
		$this->name = $name;
	}

	/**
	 * Run the installation helper.
	 *
	 * @return void
	 */
	public function install()
	{
		$this->checkDependencies();
		$this->command->output->writeln('<info>Downloading latest version of Laravel Boilerplate...</info>');
		$this->download($zipFile = $this->makeFilename())
				->extract($zipFile, $this->command->path)
				->move($old_dir = $this->command->path . '/laravel-5-boilerplate-master', $this->command->path)
				->cleanUp([$zipFile, $old_dir]);
		$this->command->output->writeln('<info>Download complete!</info>');
	}

	/**
	 * Check to see if we have everything we need for this step
	 */
	private function checkDependencies() {
		if (! class_exists('ZipArchive')) {
			throw new RuntimeException('The Zip PHP extension is not installed. Please install it and try again.');
		}
	}

	/**
	 * @return string
	 */
	private function makeFilename()
	{
		return getcwd().'/boilerplate_'.md5(time().uniqid()).'.zip';
	}

	/**
	 * @param $zipFile
	 * @return $this
	 */
	protected function download($zipFile)
	{
		$response = (new Client)->get('https://github.com/rappasoft/laravel-5-boilerplate/archive/master.zip');
		file_put_contents($zipFile, $response->getBody());
		return $this;
	}

	/**
	 * @param $currentDir
	 * @param $newDir
	 * @return $this
	 */
	protected function move($currentDir, $newDir) {
		// Get array of all source files
		$files = scandir($currentDir);

		// Identify directories
		$source = $currentDir."/";
		$destination = $newDir."/";

		foreach($files as $fname) {
			if($fname != '.' && $fname != '..') {
				rename($source.$fname, $destination.$fname);
			}
		}

		return $this;
	}

	/**
	 * @param $zipFile
	 * @param $directory
	 * @return $this
	 */
	protected function extract($zipFile, $directory)
	{
		$archive = new ZipArchive;
		$archive->open($zipFile);
		$archive->extractTo($directory);
		$archive->close();
		return $this;
	}

	/**
	 * @param $files
	 * @return $this
	 */
	protected function cleanUp($files)
	{
		if (is_array($files)) {
			foreach ($files as $file)
				$this->remove($file);
		} else
			$this->remove($files);

		return $this;
	}

	/**
	 * @param $file
	 * @return $this
	 */
	protected function remove($file) {
		if (is_dir($file))
			rmdir($file);
		else {
			@chmod($file, 0777);
			@unlink($file);
		}

		return $this;
	}
}