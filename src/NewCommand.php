<?php

namespace Rappasoft\BoilerplateInstaller;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class NewCommand extends SymfonyCommand
{
    /**
     * The input interface.
     *
     * @var InputInterface
     */
    public $input;

    /**
     * The output interface.
     *
     * @var OutputInterface
     */
    public $output;

    /**
     * The path to the new Boilerplate installation.
     *
     * @var string
     */
    public $path;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('new')
            ->setDescription('Create a new Laravel Boilerplate project')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the application');
    }

    /**
     * Execute the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = new SymfonyStyle($input, $output);
		$this->verifyApplicationDoesntExist($this->path = $input->getArgument('name') ? getcwd().'/'.$input->getArgument('name') : getcwd());

        $installers = [
            Installation\DownloadBoilerplate::class,
            Installation\ComposerInstall::class,
            /*Installation\NpmInstall::class,
            Installation\GenerateKey::class,
			Installation\RunGulp::class,
			Installation\ConnectDatabase::class,
			Installation\Migrate::class,
			Installation\SetAdministratorAccount::class,
			Installation\Seed::class,*/
        ];

        foreach ($installers as $installer) {
            (new $installer($this, $input->getArgument('name')))->install();
        }
    }

	/**
	 * @param $directory
	 */
	private function verifyApplicationDoesntExist($directory)
	{
		if ((is_dir($directory) || is_file($directory)) && $directory != getcwd()) {
			throw new RuntimeException('Application already exists!');
		}
	}
}
