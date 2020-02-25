<?php

declare(strict_types=1);

namespace App\Installer\Provider;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface DatabaseSetupCommandsProviderInterface
{
    public function getCommands(InputInterface $input, OutputInterface $output, QuestionHelper $questionHelper): array;
}
