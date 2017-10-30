<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:04
 */

namespace sokyrko\yii2menu\models;

use MongoDB\BSON\ObjectID;
use yii\db\ActiveQueryInterface;
use yii\mongodb\ActiveQuery;
use yii\mongodb\ActiveRecord;

/**
 * Class Menu
 * @package sokyrko\yii2menu\models
 * @property ObjectID $_id
 * @property string $name
 * @property MenuItem[] $items
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'name',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'menus';
    }

    /**
     * @return ActiveQueryInterface|ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(MenuItem::className(), ['menuId' => '_id'])
            ->where(['parentId' => null])
            ->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string) $this->_id;
    }
}
