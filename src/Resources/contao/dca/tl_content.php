<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Lottie Player extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use InspiredMinds\ContaoLottiePlayer\ContentElement\LottiePlayerElement;

$GLOBALS['TL_DCA']['tl_content']['palettes'][LottiePlayerElement::TYPE] = $GLOBALS['TL_DCA']['tl_content']['palettes']['headline'];
$GLOBALS['TL_DCA']['tl_content']['fields']['singleSRC']['load_callback']['lottiePlayer'] =
    [\InspiredMinds\ContaoLottiePlayer\DataContainer\ContentContainer::class, 'onSingleSRCLoadCallback'];

$GLOBALS['TL_DCA']['tl_content']['fields']['lottie_options'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['lottie_options'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'options' => [
        'autoplay',
        'controls',
        'hover',
        'loop',
    ],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['lottie_options_reference'],
    'eval' => ['multiple' => true],
    'sql' => ['type' => 'blob', 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['lottieFallbackImage'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['lottieFallbackImage'],
    'exclude'   => true,
    'inputType' => 'fileTree',
    'eval'      => ['filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => false, 'tl_class' => 'w50 clr', 'submitOnChange' => false],
    'sql'       => "binary(16) NULL",
];

PaletteManipulator::create()
    ->addLegend('lottie_legend', 'type_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('singleSRC', 'lottie_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('lottie_options', 'lottie_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('lottieFallbackImage', 'lottie_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette(LottiePlayerElement::TYPE, 'tl_content')
;
