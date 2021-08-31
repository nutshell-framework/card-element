<?php

declare(strict_types=1);

/*
 * Card Element for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2021, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       http://github.com/nutshell-framework/card-element
 */

use Nutshell\CardElement\Content\Card;

/*
 * Nutshell Card ContentElement
 */
array_insert(
    $GLOBALS['TL_CTE']['media'],
    4,
    [
        'card' => Card::class,
    ]
);
