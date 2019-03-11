<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command\Helper;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

trait CreateProgressBar
{
    /**
     * @param OutputInterface $output
     * @param int             $length
     *
     * @return ProgressBar
     */
    private function createProgressBar(OutputInterface $output, $length = 10)
    {
        $progress = new ProgressBar($output);
        $progress->setBarCharacter('<info>░</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('<comment>░</comment>');

        $progress->start($length);

        return $progress;
    }
}
