<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\system_core\TblMenuSide;
use yii\helpers\ArrayHelper;

class SideMenuNewWidget extends Widget
{
    public $side_menu;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('side-menu-new');
    }
}
