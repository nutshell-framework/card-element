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
use Contao\System;

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
        // Add the static files URL to images
        if ($staticUrl = System::getContainer()->get('contao.assets.files_context')->getStaticUrl()) {
            $path = Config::get('uploadPath') . '/';
            $this->text = str_replace(' src="' . $path, ' src="' . $staticUrl . $path, $this->text);
        }

        $this->Template->text = StringUtil::encodeEmail($this->text);
        $this->Template->addImage = false;

        // Add an image
        if ($this->addCardImage) {

            $figure = System::getContainer()
            ->get('contao.image.studio')
            ->createFigureBuilder()
            ->from($this->singleSRC)
            ->setSize($this->size)
            ->setMetadata($this->objModel->getOverwriteMetadata())
            ->enableLightbox((bool) $this->fullsize)
            ->buildIfResourceExists();

            if (null !== $figure)
            {
                $figure->applyLegacyTemplateData($this->Template, $this->imagemargin, $this->floating);
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
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $this->Template->cardUrl = '';
            $this->Template->cardTitleText = '';
            $this->Template->cardLinkTitle = '';
        }
    }
}
