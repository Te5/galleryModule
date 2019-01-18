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
    public function getLatestPictures()
    {
        //array that contains only the latest pictures
        $picturesArray = [];

        $categories = static::find()->all();
        foreach ($categories as $category) 
        {
            $maxIdPicture = Pictures::find()->where(['pic_category' => $category->cat_name])->max('id');
            $maxIdPictureModel = Pictures::find()->where(['id'=>$maxIdPicture])->one();
            
            //this adds an undefined question mark picture if category contains no pictures at all
            if (!$maxIdPictureModel)
            {
                $pictureUrl = \Yii::getAlias('@web').'/images/undefined.jpg';
            } else 
            {
                $pictureUrl = $maxIdPictureModel::getPictureUrl($maxIdPictureModel);
            }

            array_push($picturesArray, [$category->slug => $pictureUrl]);

        }
/*        print_r($picturesArray);
        die();*/
        return $picturesArray;
    }
}
