<?php

namespace common\modules\gallery\models;

use Yii;
use common\modules\gallery\models\Pictures;
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
    //this supposed to return array? of the last pictures in order to display them
    public function getLastPicture()
    {
        $query = Pictures::find()->where(['pic_category' => 'Weddings'])->max('id');
/*        $query->andFilterWhere(['like', 'pic_category', $this->cat_name]);*/
        return $query;
    }
}
