<?php

/*
 * This file is part of Alceane.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\View;

use AppBundle\View\Template\FoundationTemplate;
use Pagerfanta\View\DefaultView;

/**
 * SemanticUiView.
 *
 * View that can be used with the pagination module
 * from the Semantic UI CSS Toolkit
 * http://semantic-ui.com/
 *
 * @author Loïc Frémont <loic@mobizel.com>
 */
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
