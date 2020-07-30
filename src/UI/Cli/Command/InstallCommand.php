<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Filesystem\Filesystem;
use Zentlix\MainBundle\Application\Command\Bundle\InstallCommand as InstallBundleCommand;
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;

class InstallCommand extends ConsoleCommand {

    private CommandBus $commandBus;
    private Bundles $bundles;
    private Filesystem $filesystem;
    private KernelInterface $kernel;

    public function __construct(CommandBus $commandBus, Bundles $bundles, Filesystem $filesystem, KernelInterface $kernel)
    {
        parent::__construct();

        $this->bundles = $bundles;
        $this->commandBus = $commandBus;
        $this->filesystem = $filesystem;
        $this->kernel = $kernel;
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:install')
            ->setDescription('Install Zentlix CMS or one bundle.')
            ->addArgument('bundle', InputArgument::OPTIONAL, 'Bundle name, e.g. zentlix/shop-bundle');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $package = $input->getArgument('bundle');
        $io = new SymfonyStyle($input, $output);

        if($package) {
            $this->installSingleBundle($package, $io);
        } else {
            $this->installCMS($io, $output);
        }

        $command = $this->getApplication()->find('zentlix_main:generate:json-localization-file');
        $command->run(new ArrayInput([]), $output);

        $command = $this->getApplication()->find('cache:clear');
        $command->run(new ArrayInput([]), $output);

        $io->success(sprintf('%s successfully installed!', $package ? sprintf('Bundle %s', $package) : 'Zentlix CMS'));
    }

    private function installSingleBundle(string $package, SymfonyStyle $io): void
    {
        $bundle = $this->bundles->getByPackageName($package);

        $io->comment(sprintf('Installing <info>%s</info>', $bundle->getBundleName()));

        try {
            $this->commandBus->handle(new InstallBundleCommand($bundle));
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
        }
    }

    private function installCMS(SymfonyStyle $io, OutputInterface $output): void
    {
        $bundles = $this->bundles->getBundles();

        foreach ($bundles as $bundle) {
            $io->comment(sprintf('Installing <info>%s</info>', $bundle->getBundleName()));

            try {
                $this->commandBus->handle(new InstallBundleCommand($bundle));
            } catch (\Exception $exception) {
                $io->error($exception->getMessage());
            }
        }

        $useSecurity = $io->confirm('Use default security configuration? Otherwise, you will have to configure it yourself!');
        if($useSecurity) {
            $this->filesystem->remove($this->kernel->getProjectDir() . '/config/packages/security.yaml');
            $this->filesystem->copy(
                $this->kernel->locateResource('@UserBundle/Resources/global/packages/security.yaml'),
                $this->kernel->getProjectDir() . '/config/packages/security.yaml'
            );
        }

        $useHtaccess = $io->confirm('Use default .htaccess? Otherwise, you will have to configure web server yourself!');
        if($useHtaccess) {
            $this->filesystem->copy(
                $this->kernel->locateResource('@MainBundle/Resources/global/.htaccess'),
                $this->kernel->getProjectDir() . '/public/.htaccess'
            );
        }

        $io->section('Creating site');

        $url = $io->ask('Site URL, e.g. mysite.com', null,  function ($url) {
            if (empty($url)) {
                throw new \RuntimeException('URL cannot be empty.');
            }

            return $url;
        });

        $command = $this->getApplication()->find('zentlix_main:create:site');
        $command->run(new ArrayInput(['url' => $url]), $output);

        $io->section('Creating an administrator account');

        $email = $io->ask('Administrator Email', null,  function ($email) {
            if (empty($email)) {
                throw new \RuntimeException('Email cannot be empty.');
            }

            return $email;
        });

        $command = $this->getApplication()->find('zentlix_user:create:user');
        $command->run(new ArrayInput(['email' => $email]), $output);
    }
}
