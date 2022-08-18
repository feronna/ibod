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

class EPerkhidmatanWidget extends Widget
{
    public $options = ['class' => 'tile-stats'];
    public $icon;
    public $header;
    public $text;
    public $number;

    public function run()
    {
        echo Html::beginTag('div style="background-color: #3445db; padding: 10px; margin :0px; width: auto; height: 100px;"', $this->options);
        if (empty($this->icon) === false) {
            echo Html::tag('div', new Icon($this->icon), ['class' => 'icon']);
        }
        echo Html::tag('div style="color:   white"', $this->number, ['class' => 'count']);
        echo Html::tag('h1 style="color:   white"; font-weight: 900;', $this->header);
        echo Html::tag('p style="color:   white";', $this->text);
        echo Html::endTag('div');
    }
}
