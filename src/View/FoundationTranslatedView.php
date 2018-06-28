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

use WhiteOctober\PagerfantaBundle\View\TranslatedView;

/**
 * SemanticUiTranslatedView
 *
 * This view renders the semantic ui view with the text translated.
 */
class FoundationTranslatedView extends TranslatedView
{
    protected function previousMessageOption()
    {
        return 'prev_message';
    }

    protected function nextMessageOption()
    {
        return 'next_message';
    }

    protected function buildPreviousMessage($text)
    {
        return sprintf('%s', $text);
    }

    protected function buildNextMessage($text)
    {
        return sprintf('%s', $text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'foundation_translated';
    }
}