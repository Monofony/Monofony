<?php

/*
 * This file is part of Alceane.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\View;

use App\View\Template\FoundationTemplate;
use Pagerfanta\View\DefaultView;

class FoundationView extends DefaultView
{
    protected function createDefaultTemplate()
    {
        return new FoundationTemplate();
    }

    protected function getDefaultProximity()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'foundation';
    }
}
