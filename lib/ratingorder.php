<?
namespace BG\Rating;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;

use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class RatingOrderTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'order_rating';
    }

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //ID заказа
            new Entity\IntegerField('ID_ORDER', array(
                'required' => true,
            )),
            (new Reference(
                'ORDER',
                \Bitrix\Sale\Internals\OrderTable::class,
                Join::on('this.ID_ORDER', 'ref.ID')
            )),
            //Рейтинг доставки курьером
            new Entity\IntegerField('COURIER_RATING'),
            //Рейтинг упаковки
            new Entity\IntegerField('PACK_RATING'),
            //Рейтинг качества товара
            new Entity\IntegerField('PRODUCT_QUALITY_RATING'),
        );
    }
}


?>