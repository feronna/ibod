<?php echo $this->renderPartial('header'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengenalan', array('site/intro')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Penilaian Hidup', array('site/lifeEvaluation')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengukuran Afek', array('site/affectMeasures')); ?></li>
        <li class="breadcrumb-item active" aria-current="page">Kepuasan Kerja</li>
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
        <h5 class="font-weight-bold">B. Pengukuran Afek / <i>Affect Measures</i></h5>
    </div>
    <div class="card-body">

        <p class="text-left">
            Sila jawab satu nombor pada setiap pernyataan yang paling dekat mewakili pandangan anda.
            <br>
            <i>Please answer a number for each statement that comes closest to reflecting your opinion.</i>
        </p>

        <table class="table table-sm table-bordered table-striped custom-matrix">
            <tr class="header">
                <th class="align-center align-middle" rowspan="2" style="width: 5rem">Bil</i></th>
                <th class="align-center align-middle" rowspan="2" style="width: 30rem">Pernyataan / <i>Statement</i></th>
                <th class="align-center" colspan="6">Skala / <i>scale</i></th>
            </tr>
            <tr class="header">
                <th class="align-center">Sangat Tidak Setuju / <i>Disagree very much</i></th>
                <th class="align-center">Sederhana Tidak Setuju / <i>Disagree moderately</i></th>
                <th class="align-center">Sedikit Tidak Setuju / <i>Disagree slightly</i></th>
                <th class="align-center">Sedikit Setuju / <i>Agree slightly</i></th>
                <th class="align-center">Sederhana Setuju / <i>Agree moderately</i></th>
                <th class="align-center">Sangat Setuju / <i>Agree very much</i></th>
            </tr>
            <tr>
                <td class="align-middle align-center">1</td>
                <td class="align-middle text-left">Saya berasa dibayar dengan gaji yang setimpal dengan kerja yang saya lakukan. / <i>I feel I am being paid a fair amount for the work I do.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c1', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c1', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c1', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c1', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c1', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c1', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">2</td>
                <td class="align-middle text-left">Terdapat terlalu sedikit peluang untuk mendapat kenaikan pangkat dalam pekerjaan saya. / <i>There is really too little chance for promotion on my job.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c2', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c2', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c2', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c2', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c2', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c2', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">3</td>
                <td class="align-middle text-left">Ketua saya cukup berkebolehan dalam melaksanakan kerjanya. / <i>My supervisor is quite competent in doing his/her job.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c3', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c3', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c3', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c3', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c3', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c3', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">4</td>
                <td class="align-middle text-left">Saya tidak berpuas hati dengan faedah yang saya terima. / <i>I am not satisfied with the benefits that I receive.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c4', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c4', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c4', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c4', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c4', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c4', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">5</td>
                <td class="align-middle text-left">Ketika saya melakukan kerja dengan baik, saya menerima penghargaan yang berpatutan. / <i>When I do a good job, I receive the recognition that I deserve.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c5', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c5', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c5', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c5', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c5', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c5', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">6</td>
                <td class="align-middle text-left">Banyak peraturan dan prosedur kerja menyukarkan saya untuk melakukan kerja dengan baik. / <i>Many of our rules and procedures make doing a good job difficult.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c6', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c6', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c6', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c6', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c6', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c6', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">7</td>
                <td class="align-middle text-left">Kadang kala, saya berasa bahawa kerja saya tidak bermakna. / <i>I sometimes feel my job is meaningless.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c7', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c7', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c7', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c7', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c7', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c7', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">8</td>
                <td class="align-middle text-left">Komunikasi agak baik dalam organisasi ini. / <i>Communication seems good within this organization.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c8', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c8', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c8', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c8', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c8', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c8', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">9</td>
                <td class="align-middle text-left">Mereka yang bekerja dengan baik lebih berpeluang mendapat kenaikan pangkat. / <i>Those who do well on the job stand a fair chance of being promoted.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c9', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c9', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c9', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c9', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c9', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c9', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">10</td>
                <td class="align-middle text-left">Faedah pekerjaan yang kami terima adalah sebaik yang ditawarkan oleh organisasi lain. / <i>The benefits that we receive are as good as the ones offered by other organizations.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c10', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c10', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c10', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c10', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c10', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c10', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">11</td>
                <td class="align-middle text-left">Saya berasa bahawa kerja saya tidak dihargai. / <i>I feel that the work I do is not appreciated.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c11', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c11', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c11', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c11', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c11', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c11', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">12</td>
                <td class="align-middle text-left">Usaha saya untuk bekerja dengan baik jarang dihalang oleh birokrasi. / <i>My effort to do a good job are seldom blocked by bureaucracy.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c12', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c12', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c12', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c12', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c12', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c12', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">13</td>
                <td class="align-middle text-left">Saya perlu bekerja keras kerana rakan sekerja saya yang tidak berkebolehan. / <i>I find i have to work harder at my job because of the incompetence of people i work with</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c13', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c13', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c13', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c13', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c13', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c13', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">14</td>
                <td class="align-middle text-left">Matlamat organisasi ini tidak jelas bagi saya. / <i>The goals of this organization are not clear to me. </i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c14', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c14', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c14', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c14', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c14', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c14', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">15</td>
                <td class="align-middle text-left">Saya berasa tidak dihargai apabila saya berfikir mengenai gaji yang dibayar kepada saya. / <i>I feel unappreciated by the organization when I think about what they pay me.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c15', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c15', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c15', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c15', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c15', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c15', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">16</td>
                <td class="align-middle text-left">Ketua saya kurang berminat  dalam memahami perasaan pekerja bawahannya. / <i>My supervisor shows too little interest in the feelings of subordinates.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c16', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c16', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c16', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c16', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c16', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c16', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">17</td>
                <td class="align-middle text-left">Terlalu sedikit ganjaran diberikan kepada mereka yang bekerja di sini. / <i>There are few rewards for those who work here.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c17', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c17', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c17', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c17', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c17', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c17', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">18</td>
                <td class="align-middle text-left">Terlalu banyak kerja yang perlu saya lakukan di tempat kerja. / <i>I have too much to do at work.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c18', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c18', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c18', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c18', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c18', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c18', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">19</td>
                <td class="align-middle text-left">Saya suka rakan sekerja saya. / <i>I like my co-workers. </i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c19', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c19', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c19', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c19', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c19', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c19', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">20</td>
                <td class="align-middle text-left">Saya berasa bangga dengan pekerjaan saya. / <i>I feel proud of my job.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c20', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c20', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c20', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c20', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c20', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c20', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">21</td>
                <td class="align-middle text-left">Saya berasa puas dengan peluang kenaikan gaji saya . / <i>I feel satisfied with my chances for salary increases.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c21', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c21', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c21', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c21', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c21', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c21', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">22</td>
                <td class="align-middle text-left">Kami tidak mendapat faedah yang sepatutnya kami terima. / <i>We do not receive the benefits that we deserved.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c22', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c22', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c22', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c22', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c22', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c22', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">23</td>
                <td class="align-middle text-left">Saya suka ketua saya. / <i>I like my supervisor.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c23', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c23', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c23', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c23', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c23', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c23', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">24</td>
                <td class="align-middle text-left">Saya berpuas hati dengan peluang kenaikan pangkat saya. / <i>I am satisfied  with my chances for promotion.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c24', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c24', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c24', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c24', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c24', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c24', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">25</td>
                <td class="align-middle text-left">Terlalu banyak pertengkaran dan  konflik yang berlaku di tempat kerja saya. / <i>There are a lot of quarrels and conflicts in my workplace. </i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c25', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c25', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c25', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c25', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c25', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c25', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">26</td>
                <td class="align-middle text-left">Pekerjaan saya menyeronokkan. / <i>My job is enjoyable.</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c26', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c26', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c26', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c26', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c26', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c26', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">27</td>
                <td class="align-middle text-left">Tugasan kerja yang diberikan tidak dijelaskan dengan sepenuhnya. / <i>My work assignments are not fully explained. </i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'c27', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'c27', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'c27', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'c27', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'c27', array('value' => 5, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="6"><?php echo $form->radioButton($model, 'c27', array('value' => 6, 'uncheckValue' => null)); ?></td>
            </tr>
        </table>


    </div>
</div>

<br>

<div class="card">
    <div class="card-body">

        <?php echo CHtml::link('Sebelum / Previous', array('site/affectMeasures'), array('class' => 'btn btn-lg btn-primary')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Seterusnya / Next' : 'Seterusnya / Next', array('class' => 'btn btn-lg btn-success')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>