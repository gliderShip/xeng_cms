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
 * Change user password
 *
 */
class UserChangePasswordCommand extends ContainerAwareCommand {

    /** @var SymfonyStyle */
    protected $io;

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Change user password');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('app:user:password');
        $this->setDescription('Changes user password');

        $this->addOption('username',null,InputOption::VALUE_REQUIRED,'Please enter username!');
        $this->addOption('password',null,InputOption::VALUE_REQUIRED,'Please enter new password!');
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
        $password = $input->getOption('password');

        /** @var XUserManager $userManager */
        $userManager = $this->getContainer()->get('xeng.user_manager');
        $user=$userManager->getByUsername($username);

        if($user){

            $userManager->changePassword($user->getId(), $password);
            $output->writeln("Password changed!");
        } else {
            $output->writeln("User not found!");
        }




    }
}
