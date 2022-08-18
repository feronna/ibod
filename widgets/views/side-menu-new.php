<?php

use yii\helpers\Html;

$this->registerJs((!empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true') ? '$("div.search-menu").hide();' : '$("div.search-menu").show();');
?>

<style>
    /* .select2-selection__arrow {
        display: none;
    } */
</style>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav">
            <li>
                <div class="col-md-12 search-menu">
                    <?php

                    function processTree(&$parent, $items)
                    {
                        foreach ($items as $cell => $data) {
                            if (is_array($data['url'])) {
                                // array_push($parent, [$data['url'][0] => $data['label']]);
                                $parent[$data['url'][0]] = $data['label'];
                            }
                            if (array_key_exists('items', $data)) {
                                processTree($parent, $data['items']);
                            }
                        }
                    }

                    $callback = function ($menu) {
                        $data = $menu['data'];
                        //if have syntax error, unexpected 'fa' (T_STRING)  Errorexception,can use
                        //$data = $menu['data'];
                        return [
                            'label' => $menu['name'],
                            'url' => is_null($menu['route']) ? '#' : [$menu['route']],
                            // 'option' => $data,
                            'icon' => is_null($menu['route']) ? null : $data,
                            'items' => $menu['children'],
                        ];
                    };

                    $menuArry = \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id);
                    // $main = yii\helpers\ArrayHelper::getColumn(\mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id), 'label');

                    $ttmp = array();
                    processTree($ttmp, $menuArry);
                    // yii\helpers\VarDumper::dump(mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, null), 10, true);

                    echo kartik\select2\Select2::widget([
                        'name' => 'search_menu',
                        'data' => $ttmp,
                        // 'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => 'Search ...',
                            'id' => 'search_menu'
                            // 'style' => 'icon:yourfontfamilly'
                            // 'multiple' => true
                        ],
                        // 'pluginLoading' => false,
                        'pluginEvents' => [
                            "select2:select" => "function(e) {
                                                    // $.get('get-remark?code='+$(this).val(), function( data ) {
                                                    //     $('#remark').val(data.trim());
                                                    // });
                                                    // alert($(this).val());
                                                    var getUrl = window.location;
                                                    var baseUrl = getUrl .protocol + \"//\" + getUrl.host + \"/\" + getUrl.pathname.split('/')[1];
                                                    window.location.replace(baseUrl + \"/web\" + $(this).val());
                                                }",
                        ]
                    ]);
                    ?></div>
            </li>
        </ul>

        <?php echo \yiister\gentelella\widgets\Menu::widget(["items" => \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, null)]) ?>
    </div>
</div>