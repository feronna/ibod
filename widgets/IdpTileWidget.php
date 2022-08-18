<?php
/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

namespace app\widgets;

use rmrevin\yii\fontawesome\component\Icon;
use yii\base\Widget;
use yii\helpers\Html;

class IdpTileWidget extends Widget
{
    public $options = ['class' => 'tile-stats'];
    public $icon;
    public $header;
    public $text;
    public $number;
    public $pbar;

    public function run()
    {
        echo Html::beginTag('div style="background-color:    #3498db"', $this->options);
        if (empty($this->icon) === false) {
            echo Html::tag('div', new Icon($this->icon), ['class' => 'icon']);
        }
        echo Html::tag('div style="color:   white"', $this->number, ['class' => 'count']);
        echo Html::tag('h3 style="color:   white"', $this->header);
        echo Html::tag('p style="color:   white";', $this->text);
        if (empty($this->pbar) === false) {
            echo Html::tag('div', $this->pbar,  ['class' => 'progress progress-striped active'], ['style' =>'width: 100%'] );  
        } 
        echo Html::endTag('div');
        // echo Html::endTag('div');
    }
}
