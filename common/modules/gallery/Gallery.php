<?php

namespace common\modules\gallery;

/**
 * gallery module definition class
 */
class Gallery extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\gallery\controllers';
/*    public $layout = 'module_layout';*/
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::setAlias('@gallery', __DIR__);
        \Yii::setAlias('@assets', '@gallery/files');
        // custom initialization code goes here
    }
}
