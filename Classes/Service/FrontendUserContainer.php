<?php

declare(strict_types=1);

namespace Netresearch\Contexts\Service;

/*
 * This file is part of TYPO3 CMS-based extension contexts by b13.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Core\SingletonInterface;

class FrontendUserContainer implements SingletonInterface
{

    protected $frontendUser = null;

    /**
     * @param FrontendUserAuthentication $frontendUser
     */
    public function setFrontendUserFromRequest(FrontendUserAuthentication $frontendUser): void
    {
        $this->frontendUser = $frontendUser;
    }

    /**
     * @return FrontendUserAuthentication
     */
    public function getFrontendUser(): FrontendUserAuthentication
    {
        if ($this->getFrontendController() !== null &&
            $this->getFrontendController()->fe_user instanceof FrontendUserAuthentication) {
            return $this->getFrontendController()->fe_user;
        } else {
            return $this->frontendUser;
        }
    }

    /**
     * @return bool
     */
    public function hasFrontendUser(): bool
    {
        return (
            $this->getFrontendController() !== null &&
            $this->getFrontendController()->fe_user instanceof FrontendUserAuthentication
        ) || $this->frontendUser !== null;
    }

    /**
     * @return TypoScriptFrontendController|null
     */
    protected function getFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'] instanceof TypoScriptFrontendController ? $GLOBALS['TSFE'] : null;
    }
}
