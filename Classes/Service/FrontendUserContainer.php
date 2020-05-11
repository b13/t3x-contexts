<?php
namespace Netresearch\Contexts\Service;

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
