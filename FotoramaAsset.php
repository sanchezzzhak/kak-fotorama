<?php
namespace kak\widgets\fotorama;
 use yii\web\AssetBundle;
 /**
  * Class FotoramaAsset
  * @package kak\widgets\fotorama
  */
class FotoramaAsset extends AssetBundle
{
    const CDN = '//cdnjs.cloudflare.com/ajax/libs/fotorama/';

    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/bower/fotorama';

    public $css = [
        'fotorama.css'
    ];

    public $js = [
        'fotorama.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $version = false;

    public function registerAssetFiles($view)
    {
        /*if ($version) {;
            $this->baseUrl = self::CDN . $version;
        }*/
        parent::registerAssetFiles($view);
    }

}