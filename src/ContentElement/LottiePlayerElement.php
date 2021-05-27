<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Lottie Player extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoLottiePlayer\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\ContentModel;
use Contao\FilesModel;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;
use Webmozart\PathUtil\Path;


class LottiePlayerElement extends ContentElement
{
    public const TYPE = 'lottie_player';
    protected $strTemplate = 'ce_lottie_player';
    protected $scopeMatcher;
    protected $request;

    public function __construct(ContentModel $objElement, string $strColumn = 'main')
    {
        parent::__construct($objElement, $strColumn);
        $this->scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');
        $this->request = System::getContainer()->get('request_stack')->getCurrentRequest();
    }

    protected function compile()
    {
        if (empty($this->singleSRC)) {
            return '';
        }
        $file = FilesModel::findByUuid($this->singleSRC);

        if (null === $file || !\in_array($file->extension, ['json', 'tgs'], true)) {
            return '';
        }

        $projectDir = $this->getContainer()->getParameter('kernel.project_dir');

        $filepath = Path::join($projectDir, $file->path);

        if (!is_file($filepath)) {
            return '';
        }

        if ($this->scopeMatcher->isBackendRequest($this->request)) {
            $this->Template = new BackendTemplate($this->strTemplate);
        }

        $playerType = 'json' === $file->extension ? 'lottie' : 'tgs';
        $this->Template->playerType = $playerType;
        $this->Template->singleSRC = '/'.$file->path;
        $this->Template->lottie_options = StringUtil::deserialize($this->objModel->lottie_options, true);

        $this->addScript($playerType);

        return $this->Template->parse();
    }

    public function addScript(string $playerType = 'lottie'): void
    {
        if (!empty($GLOBALS['TL_HEAD'][$playerType.'-player-script'])) {
            return;
        }

        $script = Template::generateScriptTag('bundles/contaolottieplayer/'.$playerType.'-player.js', true);
        $script = str_replace('<script', '<script id="'.$playerType.'-player-script"', $script);
        $GLOBALS['TL_HEAD'][$playerType.'-player-script'] = $script;
    }
}
