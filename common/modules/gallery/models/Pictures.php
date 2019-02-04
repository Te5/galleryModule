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

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_MOVE = 'move';    
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
            [['author', 'pic_heading', 'pic_category', 'status'], 'required', ],
            [['watermarkPosition'], 'required', 'on' => 'default'],
            [['upload_date'], 'safe'],
            [['status'], 'string'],
            [['author', 'pic_heading', 'pic_category', 'extension'], 'string', 'max' => 255],
            [['fileImage'], 'image', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024*1024*10, 'minWidth' => 400, 'minHeight' => 400 ],
        ];
    }
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['author', 'pic_heading', 'pic_category', 'status','watermarkPosition'],
            self::SCENARIO_MOVE => ['author', 'pic_heading', 'pic_category', 'status',]];
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
/*        if(imagesx($im) < imagesy($im))
        {
            self::cropImageForThumbnail($im);
        }*/
        if($watermarkPosition!= 0)
        {
            self::addWatermark($im, $watermarkPosition);
        }
        header('Content-Type: image/jpeg');
        $image = imagejpeg($im, $url, 40);
        imagedestroy($im);
        return $image;
    }

    private function addWatermark($image, $position)
    {
        $width = imagesx($image);
        $height = imagesy($image);


        $white_color = imagecolorallocate($image, 255, 255, 255);
        $font_path = \Yii::$app->basePath.'/web/fonts/aleo.ttf';

        $text = 'Gallery.dvp';

        
        $size = self::calculateWatermarkWidth($width, $text);
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
            case 4: //right d
                $left = $width * 0.8;
                $top = $height * 0.03;
                break;
            case 3: //right u
                $left = $width * 0.85;
                $top = $height * 0.99;
                break;             
            default:
                die('Incorrect placement parametr');
                break;
        }


        return imagettftext($image, $size, $angle, $left, $top, $white_color, $font_path, $text);

/*        $image_with_watermark = imagejpeg($image);
        print_r($image_with_watermark);
        die();*/
    }

    private function cropImageForThumbnail($image)
    {
        //main purpose of this function is to resize image if it`s width is lower than height in order for it to look pretty on thumbnail
        //to be developed when i`m in the mood

    }

    private function calculateWatermarkWidth($imageWidth, $text)
    {
        //the aim of the function is to calculate the required font size of the watermark to be applied on the image.
        //You should provide your image width and text you`re going to use on watermark. Function returns a number, representing the required size.
        $font_path = \Yii::$app->basePath.'/web/fonts/aleo.ttf';
        //original font size is set to 20pt, lets calculate from that
        $tb = imagettfbbox(20, 0, $font_path, $text);
        $scale = ceil ($imageWidth / $tb[2]);
        if ($scale < 8) {
            $scale = 8;
        }
        return $scale;
    }
}
