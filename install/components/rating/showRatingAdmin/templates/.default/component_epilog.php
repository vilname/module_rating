<?
use Bitrix\Main\Context;

$action = Context::getCurrent()->getRequest()->get("action");

if ($action == 'search-order') {
 
    $content = ob_get_contents();
    ob_end_clean();
 
    $APPLICATION->RestartBuffer();
 
    list(, $content_html) = explode('<!--RestartRatingAdminBuffer-->', $content);
 
    echo $content_html;

    die;
}

?>