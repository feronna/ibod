<?php

use yii\helpers\Html;

$this->title = 'Access Manager 1.0';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
<div class="row">
    <div class="col-xs-12 col-md-3">
        

        <?php
                    $role = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Roles',
                                        'text' => 'View/Add/Edit/Delete/etc..',
                                        'number' => '1',
                                    ]
                    );
                    
                    echo Html::a($role, ['view-role']);
                    
        ?>

    </div>

    <div class="col-xs-12 col-md-3">
        <?php
                    $perm = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Permissions',
                                        'text' => 'Add/Delete',
                                        'number' => '2',
                                    ]
                    );
                    
                    echo Html::a($perm, ['view-perm']);
                    
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Role->Permissions',
                                        'text' => 'Under Development..',
                                        'number' => '3',
                                    ]
                    );
                    
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
                    \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'User->Roles',
                                        'text' => 'Under Development..',
                                        'number' => '4',
                                    ]
                    );
                    
        ?>
    </div>
</div>
        
        </div>
    </div>
</div>
