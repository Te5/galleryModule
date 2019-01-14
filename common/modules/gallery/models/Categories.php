<?php

namespace common\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $cat_name
 * @property string $slug
 * @property int $status 0 - shown, default. 1 - hidden. 2 - for authorized users only. 3 - admin only.
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_name', 'slug', 'status'], 'required'],
            [['status'], 'integer'],
            [['cat_name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }
}
