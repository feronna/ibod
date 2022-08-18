<?php

use yii\helpers\Html;
?>

<ul class="list-unstyled timeline" style="height: 800px;       /* Just for the demo          */
    overflow-y: auto;    /* Trigger vertical scroll    */
    overflow-x: auto;  /* Hide the horizontal scroll */">
    <?php foreach ($model as $data) { ?>
        <li>
            <div class="block">
                <div class="tags">
                    <a data-toggle="modal" data-target="#<?= $data->id ?>" href="#" class="tag">
                        <span><?= $data->tag ?></span>
                    </a>
                </div>
                <div class="block_content">
                    <h2 class="title">
                        <strong><?= $data->title ?></strong>
                    </h2>
                    <div class="byline">
                        <span><?= $data->tarikh ?></span> <!--by <a>Jane Smith</a>-->
                    </div>
                    <!--<p class="excerpt">-->
                        <?= $data->content ?>
                        
                        <?= $data->image ?>
                        <br><br>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#<?= $data->id ?>">Read&nbsp;More</button>
                    <!--</p>-->
                </div>
            </div>
            <div id="<?= $data->id ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><?= $data->title ?></h4>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!--<h4><?= $data->title ?></h4>-->
                            <p><?= $data->content ?><?= $data->image ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-window-close"></span>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>