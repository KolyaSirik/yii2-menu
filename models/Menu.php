<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:04
 */

namespace sokyrko\yii2menu\models;

use yii\db\ActiveQueryInterface;
use yii\mongodb\ActiveQuery;
use yii\mongodb\ActiveRecord;

/**
 * Class Menu
 * @package sokyrko\yii2menu\models
 * @property integer $id
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
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * @return ActiveQueryInterface|ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id'])
                    ->where(['parent_id' => null])
                    ->orderBy(['position' => SORT_ASC]);
    }
}
