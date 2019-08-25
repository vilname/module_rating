<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);
class bg_rating extends CModule{

    function __construct(){

        
        // echo "<pre>";
        // print_r($this->GetPath() . '/install/admin/');
        // echo "</pre>";
        

        $arModuleVersion = array();
		include(__DIR__."/version.php");

        $this->exclusionAdminFiles=array(
            '..',
            '.',
            'menu.php',
            'operation_description.php',
            'task_description.php'
        );

        $this->MODULE_ID = 'bg.rating';
        $this->MODULE_VERSION = $arModuleVerwion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVerwion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage("BG_RATING_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("BG_RATING_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("BG_RATING_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("BG_RATING_PARTNER_URI");

        $this->MODULE_SORT = 1;
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS='Y';
        $this->MODULE_GROUP_RIGHTS = "Y";

    }

    //Определяем место размещения модуля
    public function GetPath($notDocumentRoot=false)
    {
        if($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    //Проверяем что система поддерживает D7
    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }

    function InstallDB(){
        Loader::includeModule($this->MODULE_ID);

        if(!Application::getConnection(\BG\Rating\RatingOrderTable::getConnectionName())->isTableExists(
            Base::getInstance('\BG\Rating\RatingOrderTable')->getDBTableName()
            )
        )
        {
            Base::getInstance('\BG\Rating\RatingOrderTable')->createDbTable();
        }
    }

    function UnInstallDB(){
        Loader::includeModule($this->MODULE_ID);

        Application::getConnection(\BG\Rating\RatingOrderTable::getConnectionName())->
            queryExecute('drop table if exists '.Base::getInstance('\BG\Rating\RatingOrderTable')->getDBTableName());
    }

    function InstallFiles(){
        $path=$this->GetPath()."/install/components";

        if(\Bitrix\Main\IO\Directory::isDirectoryExists($path))
            CopyDirFiles($path, $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
        else
            throw new \Bitrix\Main\IO\InvalidPathException($path);

        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin'))
        {
            CopyDirFiles($this->GetPath() . "/install/admin/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin"); //если есть файлы для копирования
            // if ($dir = opendir($path))
            // {
            //     while (false !== $item = readdir($dir))
            //     {
            //         if (in_array($item,$this->exclusionAdminFiles))
            //             continue;
            //         file_put_contents($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$item,
            //             '<'.'? require($_SERVER["DOCUMENT_ROOT"]."'.$this->GetPath(true).'/admin/'.$item.'");?'.'>');
            //     }
            //     closedir($dir);
            // }
        }

        return true;
    }

    function UnInstallFiles()
	{
        \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/rating/');

        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            DeleteDirFiles($this->GetPath() . '/install/admin/', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/admin');
            // if ($dir = opendir($path)) {
            //     while (false !== $item = readdir($dir)) {
            //         if (in_array($item, $this->exclusionAdminFiles))
            //             continue;
            //         \Bitrix\Main\IO\File::deleteFile($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item);
            //     }
            //     closedir($dir);
            // }
        }
		return true;
	}

    function DoInstall(){
        global $APPLICATION;
        if($this->isVersionD7()){
            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallDB();
            $this->InstallFiles();
        }else{
            $APPLICATION->ThrowException(Loc::getMessage("BG_RATING_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("BG_RATING_INSTALL_TITLE"), $this->GetPath()."/install/step.php");
    }

    function DoUninstall(){

        global $APPLICATION;

        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        if($request["step"]<2)
        {
            $APPLICATION->IncludeAdminFile(Loc::getMessage("BG_RATING_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep1.php");
        }
        elseif($request["step"]==2)
        {
            $this->UnInstallFiles();
            if($request["savedata"] != "Y")
                $this->UnInstallDB();

            \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

            $APPLICATION->IncludeAdminFile(Loc::getMessage("ACADEMY_D7_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep2.php");
        }

    }

    function GetModuleRightList()
    {
        return array(
            "reference_id" => array("D","K","S","W"),
            "reference" => array(
                "[D] ".Loc::getMessage("BG_RATING_DENIED"),
                "[K] ".Loc::getMessage("BG_RATING_READ_COMPONENT"),
                "[S] ".Loc::getMessage("BG_RATING_WRITE_SETTINGS"),
                "[W] ".Loc::getMessage("BG_RATING_D7_FULL"))
        );
    }

}

?>