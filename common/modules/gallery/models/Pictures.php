<?php

namespace common\modules\gallery\models;

use Yii;
use yii\helpers\Url;
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
    public $watermarkPosition;
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
            [['author', 'pic_heading', 'pic_category', 'status', 'watermarkPosition' ], 'required', ],
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

    public function createCompressedImage($file, $extension, $url, $watermarkPosition) 
    {
        switch ($extension) 
        {
            case 'jpg':
                $im = imagecreatefromjpeg($file);
                break;
            case 'jpeg':
                $im = imagecreatefromjpeg($file);
                break;
            case 'gif':
                $im = imagecreatefromgif($file);
                break;
            case 'png':
                $im = imagecreatefrompng($file);
                break;
            default:
                break;

        }
        if($watermarkPosition!= 0)
        {
            self::addWatermark($im, $watermarkPosition);
        }
        header('Content-Type: image/jpeg');
        $image = imagejpeg($im, $url, 40);
        return $image;
    }

    private function addWatermark($image, $position)
    {
        $width = imagesx($image);
        $height = imagesy($image);

        $white_color = imagecolorallocate($image, 255, 255, 255);
        $font_path = \Yii::$app->basePath.'/web/fonts/aleo.ttf';

        $text = \Yii::$app->name;
        $size = 20;
        $angle = 0;
        switch ($position) {
            case 2: //left upper
                $left = $width * 0.03;
                $top = $height * 0.03;
                break;
            case 1: //left down
                $left = $width * 0.025;
                $top = $height * 0.99;            
                break;
            case 4: //right u
                $left = $width * 0.85;
                $top = $height * 0.03;
                break;
            case 3: //right u
                $left = $width * 0.8;
                $top = $height * 0.99;             
            default:
                die('Incorrect placement parametr');
                break;
        }


        return imagettftext($image, $size, $angle, $left, $top, $white_color, $font_path, $text);

/*        $image_with_watermark = imagejpeg($image);
        print_r($image_with_watermark);
        die();*/
    }

    public function cropImageForThumbnail($image)
    {


    }
}
