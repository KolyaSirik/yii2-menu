<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:06
 */

namespace sokyrko\yii2menu\models;

use MongoDB\BSON\ObjectID;
use yii\db\ActiveQueryInterface;
use yii\mongodb\ActiveQuery;
use yii\mongodb\ActiveRecord;

/**
 * Class MenuItem
 * @package sokyrko\yii2menu\models
 * @property ObjectID $_id
 * @property string $title
 * @property string $url
 * @property integer $menuId
 * @property integer $parentId
 * @property integer $position
 * @property Menu $menu
 * @property MenuItem $parent
 * @property MenuItem[] $children
 */
class MenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'menuId'], 'required'],
            [['title'], 'string', 'max' => 64],
            ['url', 'string', 'max' => 128],
            [['position'], 'integer'],
            ['parentId', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'title',
            'url',
            'menuId',
            'parentId',
            'position',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'menuItems';
    }

    /**
     * @return ActiveQueryInterface|ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['_id' => 'menuId']);
    }

    /**
     * @return ActiveQueryInterface|ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['_id' => 'parentId']);
    }

    /**
     * @return ActiveQueryInterface|ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(MenuItem::className(), ['parentId' => '_id'])->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return (string) $this->_id;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (is_string($this->menuId)) {
            $this->menuId = new ObjectID($this->menuId);
        }

        if (is_string($this->parentId)) {
            $this->parentId = new ObjectID($this->parentId);
        }

        return parent::beforeSave($insert);
    }
}
