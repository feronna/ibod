<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\system_core\TblMenuSide;
use yii\helpers\ArrayHelper;

class SideMenuWidget extends Widget
{
    public $side_menu;

    public function init()
    {
        parent::init();

        // $arry = TblMenuSide::getDb()->cache(function ($db) {
        //     return TblMenuSide::find()->where(['parent_id' => null, 'status' => 1])->orderBy(['order' => SORT_ASC, 'parent_id' => SORT_ASC])->all();
        // });

        // $arry = TblMenuSide::find()->where(['parent_id' => null, 'status' => 1])->orderBy(['order' => SORT_ASC, 'parent_id' => SORT_ASC])->all();
        $arry = TblMenuSide::find()->where(['parent_id' => null, 'status' => 1])->orderBy(['order' => SORT_ASC, 'parent_id' => SORT_ASC])->cache(0)->all();


        $this->side_menu = ArrayHelper::toArray(
            $arry,
            [
                'app\models\system_core\TblMenuSide' => [
                    'label',
                    'url' => function ($tmp) {
                        return (!empty($tmp->child2)) ? '#' : (array)$tmp->url;
                    },
                    'icon' => function ($tmp) {
                        return $tmp->icon->icon_label;
                    },
                    'visible' => function ($tmp) {
                        //return (empty($tmp->visible)) ? true : $tt;
                        switch (empty($tmp->visible)) {
                            case true:
                                return true;
                            case false:
                                //                                    ob_start();
                                //                                    eval($tmp->visible.';');
                                //                                    $tt = ob_get_contents();
                                //                                    ob_end_flush();
                                //                                    return $tt;
                                $tt = eval('return ' . $tmp->visible . ';');
                                try {
                                    return $tt;
                                } catch (\Exception $e) {
                                    return true;
                                }
                        }
                    },
                    'items' => function ($tmp) {

                        // $arry = TblMenuSide::getDb()->cache(function ($db) use ($tmp) {
                        //     return TblMenuSide::find()->where(['parent_id' => $tmp->id, 'status' => 1])->orderBy(['order' => SORT_ASC])->all();
                        // });
                        // $arry = TblMenuSide::find()->where(['parent_id' => $tmp->id, 'status' => 1])->orderBy(['order' => SORT_ASC])->all();
                        $arry = TblMenuSide::find()->where(['parent_id' => $tmp->id, 'status' => 1])->orderBy(['order' => SORT_ASC])->cache(0)->all();


                        $test = ArrayHelper::toArray($arry, [
                            'app\models\system_core\TblMenuSide' => [
                                'label',
                                'url' => function ($tp) {
                                    return (array)$tp->url;
                                },
                                //                                    'icon' => function($tp) {
                                //                                        return $tp->icon->icon_label;
                                //                                    },
                                'visible' => function ($tmp) {
                                    //return (empty($tmp->visible)) ? true : $tt;
                                    switch (empty($tmp->visible)) {
                                        case true:
                                            return true;
                                        case false:
                                            //                                                ob_start();
                                            //                                                eval($tmp->visible.';');
                                            //                                                $tt = ob_get_contents();
                                            //                                                ob_end_flush();
                                            //                                                return $tt;
                                            $tt = eval('return ' . $tmp->visible . ';');
                                            try {
                                                return $tt;
                                            } catch (\Exception $e) {
                                                return true;
                                            }
                                    }
                                },
                            ]
                        ]);
                        return $test;
                    },
                ]
            ]
        );
    }

    public function run()
    {
        return $this->render('side-menu', ['sides' => $this->side_menu]);
    }
}
