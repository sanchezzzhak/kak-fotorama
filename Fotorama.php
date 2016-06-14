<?php
/**
 * Created by PhpStorm.
 * User: PHPdev
 * Date: 13.06.2016
 * Time: 18:26
 */

namespace kak\widgets\fotorama;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class Fotorama extends Widget
{

    public $tagName = 'div';

    /**
     * Html options
     * @var array
     */
    public $htmlOptions = [];

    /**
     * Using of html data-params, if false - js object initialization
     *
     * @var bool
     */
    public $useHtmlData = true;

    /**
     * Widget options
     *
     * ```php
     * 'options' => [
     *      'width' => '50%', // Number or String. Stage container width in pixels or percents.
     *      'minwidth' => '40%', // Number or String. Stage container minimum width in pixels or percents.
     *      'maxwidth' => 300, // Number or String. Stage container maximum width in pixels or percents.
     *      'height' => 500, // Number or String. Stage container height in pixels or percents.
     *      'minheight' => '500px', // Number or String. Stage container minimum height in pixels or percents.
     *      'maxheight' => '100px', // Number or String. Stage container maximum height in pixels or percents.
     *      'ratio' => 800/600, // Number or String. Width divided by height. Recommended if you’re using percentage width.
     *      'margin' => 10, // Number. Horizontal margins for frames in pixels.
     *      'glimpse' => '100px', // Number or String. Glimpse size of nearby frames in pixels or percents.
     *      'nav' => 'thumbs', // Boolean or String. Navigation style: 'dots' (iPhone-style dots), 'thumbs' (Thumbnails), false (Nothing)
     *      'navposition' => 'bottom', // String. Navigation block position relative to stage: 'bottom' or 'top'.
     *      'thumbwidth' => 100, // Number. Tumbnail width in pixels.
     *      'thumbheight' => 100, // Number. Tumbnail height in pixels.
     *      'thumbmargin' => 10, // Number. Size of thumbnail margins.
     *      'thumbborderwidth' => 5, // Number. Border width of the active thumbnail.
     *      'allowfullscreen' => true, // Boolean or String. Allows fullscreen: false (Default), true, 'native'
     *      'fit' => 'cover', // String. How to fit an image into a fotorama: 'contain' (Default), 'cover', 'scaledown', 'none'
     *      'transition' => 'slide', // String. Defines what transition to use: 'slide' (Default), 'crossfade', 'dissolve'
     *      'transitionduration' => 3000, // Number. Animation length in milliseconds.
     *      'captions' => true, // Boolean. Captions visibility.
     *      'hash' => false, // Boolean. Hash in urls
     *      'startindex' => 3, // Number or String. Index or id of the frame that will be shown upon initialization of the fotorama.
     *      'loop' => true, // Boolean. Enables loop.
     *      'autoplay' => true, // Boolean or Number. Enables slideshow. Turn it on with true or any interval in milliseconds.
     *      'stopautoplayontouch' => '', // Boolean. Stops slideshow at any user action with the fotorama.
     *      'keyboard' => true, // Boolean. Enables keyboard navigation.
     *      'arrows' => true, // Boolean. Turns on navigation arrows over the frames.
     *      'click' => true, // Boolean. Moving between frames by clicking.
     *      'swipe' => true, // Boolean. Moving between frames by swiping.
     *      'trackpad' => true, // Boolean. Enables trackpad support and horizontal mouse wheel as well.
     *      'shuffle' => true, // Boolean. Shuffles frames at launch.
     *      'direction' => 'ltr', // String. Sets the frames direction: 'ltr' or 'rtl'.
     *      'shadows' => true, // Boolean. Enables shadows.
     * ],
     * ```
     *
     * @var array {@link http://fotorama.io/customize/ Fotorama options}
     */
    public $clientOptions = [];

    /**
     * Add items as js objects
     *
     * ```php
     * 'items' => [
     *      [
     *          'img' => '1.jpg',
     *          'thumb' => '1-thumb.jpg',
     *          'full' => '1-full.jpg', // Separate image for the fullscreen mode.
     *          'video' => 'http://youtu.be/C3lWwBslWqg', // Youtube, Vimeo or custom iframe URL
     *          'id' => 'one', // Custom anchor is used with the hash:true option.
     *          'caption' => 'The item caption',
     *          'html' => new \yii\web\JsExpression('jQuery("selector")'), // ...or '<div>123</div>'. Custom HTML inside the frame.
     *          'fit' => 'cover', // Override the global fit option.
     *          'any' => 'Any data relative to the frame you want to store',
     *      ],
     * ],
     * ```
     *
     * @var array {@link http://fotorama.io/customize/initialization/#frame-object item options}
     */
    public $items = [];

    /**
     * Loader (spinner) object config
     *
     * ```php
     * 'spinner' => [
     *      'lines' => 13, // The number of lines to draw
     *      'length' => 20, // The length of each line
     *      'width' => 10, // The line thickness
     *      'radius' => 30, // The radius of the inner circle
     *      'corners' => 1, // Corner roundness (0..1)
     *      'rotate' => 0, // The rotation offset
     *      'direction' => 1, // 1: clockwise, -1: counterclockwise
     *      'color' => '#000', // #rgb or #rrggbb or array of colors
     *      'speed' => 1, // Rounds per second
     *      'trail' => 60, // Afterglow percentage
     *      'shadow' => false, // Whether to render a shadow
     *      'hwaccel' => false, // Whether to use hardware acceleration
     *      'zIndex' => 1000, // The z-index (defaults to 2000000000)
     *      'top' => '50%', // Top position relative to parent
     *      'left' => '50%' // Left position relative to parent
     * ],
     * ```
     *
     * @var array {@link http://fgnass.github.io/spin.js/ spin.js options}
     */
    public $spinner = [];


    public function initOptions()
    {
        if (empty($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->id;
        }

        if ($this->useHtmlData) {

            if (isset($this->clientOptions['data'])) {
                $this->items =  ArrayHelper::remove($this->clientOptions,'data',[]);
            }
            if (isset($this->clientOptions['spinner'])) {
                $this->spinner = ArrayHelper::remove($this->clientOptions,'spinner',[]);
            }

            foreach ($this->clientOptions as $option => $value) {
                $this->htmlOptions['data-' . $option] = $value;
            }
            $this->clientOptions = [];
        }

        $this->htmlOptions['data-auto'] = 'false';
        if (!empty($this->items)) {
            $this->clientOptions['data'] = $this->items;
        }
        if (!empty($this->spinner)) {
            $this->clientOptions['spinner'] = $this->spinner;
        }
    }

    public function init(){
        parent::init();

        $this->initOptions();

        Html::addCssClass($this->htmlOptions['class'],'fotorama kak-fotorama');
        echo Html::beginTag($this->tagName, $this->htmlOptions) . "\n";
    }

    public function run()
    {
        echo Html::endTag($this->tagName);
        $this->registerAssets();
    }

    public function registerAssets($position = View::POS_READY, $key = null)
    {
        FotoramaAsset::register($this->view);
        $clientOptions = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
        $this->view->registerJs("jQuery('#{$this->id}').fotorama({$clientOptions})", $position, $key);
    }

}