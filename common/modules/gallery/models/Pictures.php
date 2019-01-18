<?php

namespace common\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "pictures".
 *
 * @property int $id
 * @property string $author
 * @property string $pic_heading
 * @property string $pic_category
 * @property string $upload_date
 * @property string $status 0 - shown, default. 1 - hidden. 2 - for authorized users only. 3 - admin only.
 */
class Pictures extends \yii\db\ActiveRecord
{
    public $url;
    public $fileImage;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pictures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author', 'pic_heading', 'pic_category', 'status', ], 'required', ],
            [['upload_date'], 'safe'],
            [['status'], 'string'],
            [['author', 'pic_heading', 'pic_category', 'extension'], 'string', 'max' => 255],
            [['fileImage'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024*1024*10, ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'pic_heading' => 'Title',
            'pic_category' => 'Category',
            'upload_date' => 'Upload Date',
            'status' => 'Status',
            'fileImage' => 'Image',
        ];
    }
    public function getPictureUrl($model) 
    {
        return \Yii::getAlias('@web').'/images/'.$model->pic_category.'/'.$model->id.'.'.$model->extension;
    }

}
