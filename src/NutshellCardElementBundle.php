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

namespace Nutshell\CardElement;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NutshellCardElementBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
