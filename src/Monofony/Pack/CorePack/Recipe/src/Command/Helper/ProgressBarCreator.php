<?php

declare(strict_types=1);

namespace App\Command\Helper;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

final class ProgressBarCreator
{
    public function create(OutputInterface $output, int $length = 10): ProgressBar
    {
        $progress = new ProgressBar($output);
        $progress->setBarCharacter('<info>░</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('<comment>░</comment>');

        $progress->start($length);

        return $progress;
    }
}
