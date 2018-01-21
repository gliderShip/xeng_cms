<?php

namespace AppBundle\Command;

use AppBundle\Services\Auth\XUserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 * User creation command
 *
 */
class UserCreateCommand extends ContainerAwareCommand {

    /** @var SymfonyStyle */
    protected $io;

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('HH Site Create User');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('app:user:create');
        $this->setDescription('Creates a new user');

        $this->addOption('username',null,InputOption::VALUE_REQUIRED,'Please enter username!');
        $this->addOption('email',null,InputOption::VALUE_REQUIRED,'Please enter email!');
        $this->addOption('password',null,InputOption::VALUE_REQUIRED,'Please enter password!');
    }

    /**
     * {@inheritdoc}
     *
     */
    protected function interact(InputInterface $input, OutputInterface $output) {

        foreach ($input->getOptions() as $option => $value) {
            if ($value === null) {
                $input->setOption($option, $this->io->ask(sprintf('%s', ucfirst($option))));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $username = $input->getOption('username');
        $email = $input->getOption('email');
        $password = $input->getOption('password');

        /** @var XUserManager $userManager */
        $userManager = $this->getContainer()->get('xeng.user_manager');
        $userManager->createUser($username,$email,$password, true);
    }
}
