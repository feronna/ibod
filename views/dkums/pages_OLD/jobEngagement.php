<?php echo $this->renderPartial('header'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengenalan', array('site/intro')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Penilaian Hidup', array('site/lifeEvaluation')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengukuran Afek', array('site/affectMeasures')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Kepuasan Kerja', array('site/jobSatisfaction')); ?></li>
        <li class="breadcrumb-item active" aria-current="page">Keterlibatan Kerja</li>
    </ol>
</nav>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'jobStatisfaction-form',
    'enableAjaxValidation' => false,
        ));
?>

<div class="card">
    <div class="card-header text-left">
        <h5 class="font-weight-bold">D. Keterlibatan Kerja / <i>Job Engagement</i></h5>
    </div>
    <div class="card-body">

        <p class="text-left">
            Berikut merupakan sembilan pernyataan tentang bagaimana perasaan anda di tempat kerja. 
            Sila baca setiap pernyataan dengan berhati-hati dan pilih salah satu perasaan yang berkaitan dengan pekerjaan anda. 
            Jika anda tidak pernah merasa perasaan tersebut, tandakan ‘0’ pada ruangan yang disediakan. 
            Jika anda pernah mengalami perasaan ini, tandakan nombor 1 hingga 6 untuk menggambarkan berapa kerap anda mengalami perasaan tersebut.

        </p>
        <p class="text-left">
            <i>
                The following nine statements are about how you feel at work. 
                Please read each statement carefully and decide if you ever feel this way about your job. 
                If you have never had this feeling, cross the ‘0’ (zero) in the space after the statement. 
                If you have had this feeling, indicate how often you feel it by crossing the number (from 1 to 6) that best describes how frequently you feel that way.
            </i>
        </p>

        <table class="table table-sm table-bordered table-striped custom-matrix">
            <tr>
                <th class="align-center align-middle" rowspan="2" style="width: 5rem">Bil</i></th>
                <th class="align-center align-middle" rowspan="2" style="width: 15rem">Pernyataan / <i>Statement</i></th>
                <th class="align-center" colspan="7">Skala / <i>scale</i></th>
            </tr>
            <tr>
                <th class="align-center">Tidak pernah <i>Never</i></th>
                <th class="align-center">Hampir Tidak Pernah <i>Disagree moderately</i><br><br> Beberapa kali setahun atau kurang <i>A few times a year or less</i></th>
                <th class="align-center">Jarang-jarang <i>Rarely</i><br><br>Sekali Sebulan atau kurang <i>Once a month or less</i></th>
                <th class="align-center">Kadang-kadang <i>Sometimes</i><br><br>Beberapa kali sebulan<i>A few times a month</i></th>
                <th class="align-center">Kerap <i>Often</i><br><br>Sekali Seminggu<i>Once a week</i></th>
                <th class="align-center">Sangat Kerap <i>Very often</i><br><br>Beberapa Kali Seminggu <i>A few times a week</i></th>
                <th class="align-center">Selalu <i>Always</i><br><br>Setiap Hari<i>Every day</i></th>
            </tr>
            <tr>
                <td class="align-middle align-center">1</td>
                <td class="align-middle text-left">Di tempat kerja, saya berasa sangat bertenaga. / <i>At my work, I am very energetic.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd1', array('value' =>' 0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd1', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd1', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd1', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd1', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd1', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd1', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">2</td>
                <td class="align-middle text-left">Saya rasa kuat dan bersemangat dengan pekerjaan saya. / <i> I feel strong and vigorous with my job.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd2', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd2', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd2', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd2', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd2', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd2', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd2', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">3</td>
                <td class="align-middle text-left">Saya bersemangat dengan pekerjaan saya. / <i> I am enthusiastic about my job.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd3', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd3', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd3', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd3', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd3', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd3', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd3', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">4</td>
                <td class="align-middle text-left">Pekerjaan saya memberi inspirasi kepada saya. / <i> My job inspires me.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd4', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd4', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd4', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd4', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd4', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd4', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd4', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">5</td>
                <td class="align-middle text-left">Apabila bangun pagi, saya rasa suka pergi bekerja. / <i> When I get up in the morning, I feel like going to work.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd5', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd5', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd5', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd5', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd5', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd5', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd5', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">6</td>
                <td class="align-middle text-left">Saya gembira apabila saya bekerja keras. / <i> I feel happy when I am working intensely.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd6', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd6', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd6', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd6', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd6', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd6', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd6', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">7</td>
                <td class="align-middle text-left">Saya bangga dengan kerja yang saya lakukan. / <i> I am proud of the work that I do.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd7', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd7', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd7', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd7', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd7', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd7', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd7', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">8</td>
                <td class="align-middle text-left">Saya terlibat sepenuhnya dalam kerja saya. / <i> I am immersed in my work.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd8', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd8', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd8', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd8', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd8', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd8', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd8', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">9</td>
                <td class="align-middle text-left">Saya terlalu pentingkan kerja sehingga boleh lupa segalanya. / <i> I get carried away when I’m working.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="0"><?php echo $form->radioButton($model, 'd9', array('value' =>'0', 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'd9', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'd9', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'd9', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'd9', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'd9', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'd9', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">

        <?php echo CHtml::link('Sebelum / Previous', array('site/jobSatisfaction'), array('class' => 'btn btn-lg btn-primary')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Seterusnya / Next' : 'Seterusnya / Next', array('class' => 'btn btn-lg btn-success')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
