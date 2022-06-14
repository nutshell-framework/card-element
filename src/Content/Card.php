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

namespace Nutshell\CardElement\Content;

use Contao\Config;
use Contao\ContentElement;
use Contao\FilesModel;
use Contao\StringUtil;
use Contao\Validator;

class Card extends ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_card';

    /**
     * Generate the content element.
     */
    protected function compile()
    {
        /* @var \PageModel $objPage */
        global $objPage;

        // Clean the RTE output
        if ('xhtml' === $objPage->outputFormat) {
            $this->text = StringUtil::toXhtml($this->text);
        } else {
            $this->text = StringUtil::toHtml5($this->text);
        }

        // Add the static files URL to images
        if (TL_FILES_URL) {
            $path = Config::get('uploadPath').'/';
            $this->text = str_replace(' src="'.$path, ' src="'.TL_FILES_URL.$path, $this->text);
        }

        $this->Template->text = StringUtil::encodeEmail($this->text);
        $this->Template->addImage = false;

        // Add an image
        if ($this->addCardImage && $this->singleSRC) {
            $objModel = FilesModel::findByUuid($this->singleSRC);

            if (null === $objModel) {
                if (!Validator::isUuid($this->singleSRC)) {
                    $this->Template->text = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
                }
            } elseif (is_file(TL_ROOT.'/'.$objModel->path)) {
                $this->singleSRC = $objModel->path;
                static::addImageToTemplate($this->Template, $this->arrData);
            }
        }

        $this->Template->url = $this->cardUrl;
        $this->Template->href = $this->cardUrl;
        $this->Template->link = $this->cardLinkTitle;

        if ($this->cardTitleText) {
            $this->Template->linkTitle = StringUtil::specialchars($this->cardTitleText);
        }

        // Override the link target
        if ($this->cardTarget) {
            $this->Template->target = ' target="_blank"';
            $this->Template->rel = ' rel="noreferrer noopener"';
        }

        // Unset the title attributes in the back end (see #6258)
        if (TL_MODE === 'BE') {
            $this->Template->cardUrl = '';
            $this->Template->cardZitleText = '';
            $this->Template->cardLinkTitle = '';
        }
    }
}
