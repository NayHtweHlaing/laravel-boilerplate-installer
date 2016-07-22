<?php

namespace Rappasoft\BoilerplateInstaller;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * Class NewCommand
 * @package Rappasoft\BoilerplateInstaller
 */
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
	 * Whether or not composer was run
	 * @var bool
	 */
	public $depencies_installed = false;

	/**
	 * Keeps track of whether or not NPM dependencies were installed
	 * so we know whether or not to ask to run gulp later on
	 * @var bool
	 */
	public $npm_installed = false;

	/**
	 * Keeps track of whether or not database credentials were supplied
	 * so we know whether or not to ask to run migrate and seed
	 * @var bool
	 */
	public $database_set = false;

	/**
	 * Whether or not the migrations were ran
	 * so we know whether or not to ask to run the seeder
	 * @var bool
	 */
	public $migrations_run = false;

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
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the application');
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
		$name = $input->getArgument('name');
		$this->verifyApplicationDoesntExist($this->path = $name ? getcwd().'/'.$name : getcwd());

        $installers = [
            Installation\DownloadBoilerplate::class,
            Installation\ComposerInstall::class,
            Installation\NpmInstall::class,
			Installation\RunGulp::class,
            Installation\GenerateKey::class,
			Installation\SetNamespace::class,
			Installation\ConnectDatabase::class,
			Installation\Migrate::class,
			Installation\SetAdministratorAccount::class,
			Installation\Seed::class,
        ];

        foreach ($installers as $installer) {
            (new $installer($this, $name))->install();
        }

		$output->writeln('<info>Installation Complete!</info>');
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
