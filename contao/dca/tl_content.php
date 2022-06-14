<?php

declare(strict_types=1);

/*
 * Card Element for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2022, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       http://github.com/nutshell-framework/card-element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'addText';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'addCardImage';

$GLOBALS['TL_DCA']['tl_content']['palettes']['card'] = '{type_legend},type,headline;'
                                                       .'{text_legend},addText;'
                                                       .'{image_legend},addCardImage;'
                                                       .'{link_legend},cardUrl,cardTarget,cardLinkTitle,cardTitleText;'
                                                       .'{template_legend:hide},customTpl;'
                                                       .'{protected_legend:hide},protected;'
                                                       .'{expert_legend:hide},guests,cssID,space;'
                                                       .'{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addText'] = 'text';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['addCardImage'] = 'singleSRC,size';

$GLOBALS['TL_DCA']['tl_content']['fields']['cardUrl'] = [
    'label' => &$GLOBALS['TL_LANG']['MSC']['url'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'tl_class' => 'w50 wizard'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['cardTarget'] = [
    'label' => &$GLOBALS['TL_LANG']['MSC']['target'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['cardLinkTitle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['linkTitle'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['cardTitleText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['titleText'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['addText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['addText'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['addCardImage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['addImage'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true],
    'sql' => "char(1) NOT NULL default ''",
];
