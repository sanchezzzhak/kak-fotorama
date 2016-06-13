<?php
/**
 * Created by PhpStorm.
 * User: PHPdev
 * Date: 13.06.2016
 * Time: 18:26
 */

namespace kak\widgets\fotorama;
use yii\base\Widget;
use yii\helpers\Html;

class Fotorama extends Widget
{

    public $templateItem = '';

    public $tagName = 'div';
    public $htmlOptions = [];

    public function init(){
        parent::init();
        echo Html::beginTag($this->tagName, $this->htmlOptions) . "\n";
    }

    public function run()
    {
        echo Html::endTag($this->tagName);
    }

    public function registerAssets()
    {
        FotoramaAsset::register($this->view);

    }

}