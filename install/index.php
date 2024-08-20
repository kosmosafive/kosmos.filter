<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class kosmos_filter extends CModule
{
    public $MODULE_ID = 'kosmos.filter';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('KOSMOS_FILTER_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('KOSMOS_FILTER_MODULE_DESCRIPTION');

        $this->PARTNER_NAME = Loc::getMessage('KOSMOS_FILTER_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('KOSMOS_FILTER_PARTNER_URI');
    }

    public function DoInstall(): void
    {
        global $APPLICATION;

        ModuleManager::registerModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('KOSMOS_COMMENT_INSTALL_TITLE'),
            $this->GetPath() . '/install/step.php'
        );
    }

    public function DoUninstall(): void
    {
        global $APPLICATION;

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('KOSMOS_COMMENT_UNINSTALL_TITLE'),
            $this->GetPath() . '/install/unstep2.php'
        );
    }

    public function GetPath($notDocumentRoot = false): string
    {
        if($notDocumentRoot){
            return str_ireplace(realpath(Application::getDocumentRoot()), '', dirname(__DIR__));
        }

        return dirname(__DIR__);
    }
}