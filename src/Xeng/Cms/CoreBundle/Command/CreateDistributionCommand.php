<?php
// src/Xeng/Cms/CoreBundle/Command/CreateDistributionCommand.php

namespace Xeng\Cms\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Ermal Mino <ermal.mino@gmail.com>
 *
 */
class CreateDistributionCommand extends Command{

    protected function configure(){
        $this
            // the name of the command (the part after "app/console")
            ->setName('xeng:dist')

            // the short description shown while running "php app/console list"
            ->setDescription('Creates a distribution release ready to be uploaded on a shared hosting')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a distribution release ready to be uploaded on a shared hosting...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }

}