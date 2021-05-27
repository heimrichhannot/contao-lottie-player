<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Lottie Player extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoLottiePlayer\DataContainer;

use Contao\DataContainer;
use InspiredMinds\ContaoLottiePlayer\ContentElement\LottiePlayerElement;

class ContentContainer
{
    public function onSingleSRCLoadCallback($value, DataContainer $dc)
    {
        if (!$dc->activeRecord || LottiePlayerElement::TYPE !== $dc->activeRecord->type) {
            return $value;
        }

        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = 'json,tgs';

        return $value;
    }
}
