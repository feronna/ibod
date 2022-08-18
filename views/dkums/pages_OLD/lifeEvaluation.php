<?php echo $this->renderPartial('header'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengenalan', array('site/intro')); ?></li>
        <li class="breadcrumb-item active" aria-current="page">Penilaian Hidup</li>
    </ol>
</nav>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'lifeEvaluation-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="card">
    <div class="card-header text-left">
        <h5 class="font-weight-bold">A. Penilaian Hidup / <i>Life Evaluation</i></h5>
    </div>
    <div class="card-body">


        <table class="table table-sm table-bordered table-striped custom-matrix">
            <tr>
                <th style="width: 30rem">Cantril's Ladder of Life Scale</th>
                <th colspan="2">Skala / Scale</th>
            </tr>
            <tr>
                <td rowspan="12">
                    <p class="text-left">
                        “Sila bayangkan satu tangga yang mana tapak yang paling bawah adalah bernilai 0 dan tapak yang paling atas adalah bernilai 10. 
                        Puncak tangga tersebut merupakan kehidupan yang paling baik bagi anda manakala bahagian paling bawah tangga tersebut adalah kehidupan yang paling teruk bagi anda. 
                        Pada tapak manakah anda berdiri di tangga ini sekarang?”
                    </p>
                    <p class="text-left" style="color: green">
                        <i>
                            Please imagine a ladder, with steps numbered from 0 at the bottom to 10 at the top. 
                            The top of the ladder represents the best possible life for you and the bottom of the ladder represents the worst possible life for you. 
                            On which step of the ladder would you personally feel that you stand at this time?”
                        </i>
                    </p>
                </td>
            </tr>
            <!-- Eval -->
            <tr>
                <th>10</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 10, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>9</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 9, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>8</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 8, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>7</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 7, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>6</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>5</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>4</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 4, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>3</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 3, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>2</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 2, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>1</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => 1, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <th>0</th>
                <td><?php echo $form->radioButton($model, 'a1', array('value' => '0', 'uncheckValue' => null)); ?></td>
            </tr>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">

        <?php echo CHtml::link('Sebelum / Previous', array('site/intro'), array('class' => 'btn btn-lg btn-primary')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Seterusnya / Next' : 'Seterusnya / Next', array('class' => 'btn btn-lg btn-success')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        $("input:radio").attr("checked", false);
    });
</script>
