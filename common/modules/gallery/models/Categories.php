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
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_DELETE = 'delete';

    public $adminDeletionChoice;
    public $categoryToReceiveImages;

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
            [['adminDeletionChoice'], 'required', 'on' => ['delete']],
            [['status'], 'integer'],
            [['cat_name', 'slug'], 'string', 'max' => 255],
            [['cat_name', 'slug'], 'unique'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['cat_name', 'slug', 'status'],
            self::SCENARIO_DELETE => ['cat_name', 'slug', 'status', 'adminDeletionChoice', 'categoryToReceiveImages'],];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Category name',
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
            $recordQuantity = Pictures::find()->where(['pic_category' => $category->cat_name])->count();
            //this adds an undefined question mark picture if category contains no pictures at all
            
            if (!$maxIdPictureModel)
            {
                $pictureUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Question_Mark.svg/2000px-Question_Mark.svg.png';
            } else 
            {
                $pictureUrl = $maxIdPictureModel::getPictureUrl($maxIdPictureModel);
            }

            $picturesArray[$category->cat_name] =
            [
                'url' => $pictureUrl,
                'records' => $recordQuantity,
                'slug' => $category->slug,
                'cat_name'=> $category->cat_name,
            ];
        }

        return $picturesArray;
    }

    public function categoryDeletionHandler($choice, $category, $donorCategory = null)
    {

        $pictureModels = Pictures::find()->where(['pic_category'=>$this->cat_name])->all();

        $category = Categories::findOne(['cat_name'=>$category]);

        $oldDir = \Yii::$app->basePath.'/web/images/'.$this->cat_name;
        $catFiles = scandir($oldDir);
        unset($catFiles[0]);
        unset($catFiles[1]);

        if($choice == 0) // if admin decided to move to another category
        {
            foreach ($pictureModels as $model) 
            {  
                $model->scenario = Pictures::SCENARIO_MOVE;  
                $model->pic_category = $donorCategory;
/*                $model->validate();
                print_r($model->getErrors());
                die();*/
                $model->save();
            }            

            $newDir = \Yii::$app->basePath.'/web/images/'.$donorCategory;       
            foreach ($catFiles as $image) 
            {
                rename($oldDir.'/'.$image, $newDir. '/'.$image);
            }


            
        }
        elseif ($choice == 1 ) 
        {
            foreach ($catFiles as $image) 
            {
                unlink($oldDir . '/'.$image);
            }
        }
        rmdir($oldDir);
        $category->delete();

        return true;
    }
}
