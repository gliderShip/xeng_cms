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
 * User make user super admin
 *
 */
class MakeSuperAdminCommand extends ContainerAwareCommand {

    /** @var SymfonyStyle */
    protected $io;

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Make a user super admin');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('app:user:super');
        $this->setDescription('Makes a user superadmin');

        $this->addOption('username',null,InputOption::VALUE_REQUIRED,'Please enter username!');
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

        /** @var XUserManager $userManager */
        $userManager = $this->getContainer()->get('xeng.user_manager');
        $user=$userManager->getByUsername($username);

        if($user){
            if($user->hasRole('ROLE_SUPER_ADMIN')){
                $output->writeln("User already super admin!");
                return;
            }
            $user->addRole('ROLE_SUPER_ADMIN');
            $userManager->saveUser($user);
        } else {
            $output->writeln("User not found!");
        }

    }
}
