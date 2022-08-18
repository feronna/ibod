<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        'ICNO',
        'COOldID',
        ['label' => 'Gelaran',
            'value' => $model->gelaran],
        'CONm',
        ['label' => 'Agama',
            'value' => function($model) {
                return $model->displayAgama;
            }],
        ['label' => 'Bangsa',
            'value' => function($model) {
                return $model->displayBangsa;
            }],
        ['label' => 'Etnik',
            'value' => function($model) {
                return $model->displayEtnik;
            }],
        ['label' => 'Jenis Darah',
            'value' => function($model) {
                return $model->displayJenisDarah;
            }],
        ['label' => 'Jantina',
            'value' => function($model) {
                return $model->displayJantina;
            }],
        ['label' => 'Taraf Perkahwinan',
            'value' => function($model) {
                return $model->displayTarafPerkahwinan;
            }],
        'COBirthCertNo',
        'COBirthDt',
        ['label' => 'Negara Lahir',
            'value' => function($model) {
                return $model->displayNegaraLahir;
            }],
        ['label' => 'Tempat Lahir',
            'value' => function($model) {
                return $model->displayTempatLahir;
            }],
        ['label' => 'Warganegara',
            'value' => function($model) {
                return $model->displayWarganegara;
            }],
        ['label' => 'Status Warganegara',
            'value' => function($model) {
                return $model->displayStatusWarganegara;
            }],
        ['label' => 'Status Bumiputera',
            'value' => function($model) {
                return $model->displayStatusBumiputera;
            }],
        'COEmail:email',
        'COHPhoneNo',
        ['label' => 'Status Telefon Aktif',
            'value' => function($model) {
                return $model->displayStatusPhone;
            }],
        ['label' => 'Pendidian Tertinggi',
            'value' => function($model) {
                return $model->displayPendidikan;
            }],
        'ConfermentDt',
        ['label' => 'Status Uniform',
            'value' => function($model) {
                return $model->displayStatusUniform;
            }],
    ],
])
?>

//////////////////

normal view

<div class="tblbahasa-view">
    <p>
<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<?=
Html::a('Delete', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
])
?>
    </p>

<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        'ICNO',
        'LangSkillOral',
        'LangCd',
        'LangSkillWritten',
        'LangSkillCert',
        'id',
    ],
])
?>

</div>

<i class="fa fa-eye" aria-hidden="true"></i> 

<i class="fa fa-pencil" aria-hidden="true"></i>

<i class="fa fa-trash" aria-hidden="true"></i>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negaraKelahiran">Negara Kelahiran: <span class="required" style="color:red;">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

    <?=
    $form->field($model, 'COBirthCountryCd')->label(false)->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Negara::find()->all(), 'CountryCd', 'Country'),
        'options' => ['placeholder' => 'Pilih Negara', 'class' => 'form-control col-md-7 col-xs-12'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tempatKelahiran">Tempat Kelahiran: <span class="required" style="color:red;">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

<?=
$form->field($model, 'COBirthPlaceCd')->label(false)->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
    'options' => ['placeholder' => 'Pilih Negeri', 'class' => 'form-control col-md-7 col-xs-12'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    </div>
</div>

<tr> 
    <td class="text-center"><i class="fa fa-briefcase" aria-hidden="true"></i></td>
    <td>&nbsp;<?= Html::a('Permit Kerja', ['permitkerja/view', 'icno' => $model->ICNO]) ?></td>
</tr>

<!--                <div class="col-lg-4 col-md-12  col-xs-12 ">
                    <img height='80px' src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg">
                </div>-->

<div class="col-lg-6 col-md-12  col-xs-12 ">

    <div class="col-lg-5 col-md-4 col-xs-4"><span class="alignright border"><b>Nama:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8 align-center"><span><?= ucwords(strtolower($model->CONm)) ?></span></div>

</div> 
<div class="col-lg-6 col-md-12  col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>No. KP / Paspot:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= $model->ICNO ?></span></div>

</div>
<div class="col-lg-6 col-md-12  col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Jabatan:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= ucwords(strtolower($model->department->fullname)) ?></span></div>

</div>
<div class="col-lg-6 col-md-12  col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Kampus Cawangan:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= ucwords(strtolower($model->kampus->campus_name)) ?></span></div>

</div>
<div class="col-lg-6 col-md-12  col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>UMSPER:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= $model->COOldID ?></span></div>

</div>
<div class="col-lg-6 col-md-12  col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Jawatan Disandang:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= $model->jawatan->nama . "(" . $model->jawatan->gred . ")"; ?></span></div>

</div>
<div class="col-lg-6 col-md-12 col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Status Sandangan:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span><?= $model->statusSandangan->sandangan_name ?></span></div>

</div>
<div class="col-lg-6 col-md-12 col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Tarikh Mula Sandangan:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= Yii::$app->formatter->format($model->startDateSandangan, ['date', 'dd MMM Y']) ?></span></div>

</div>
<div class="col-lg-6 col-md-12 col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Status Jawatan:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= $model->statusLantikan->ApmtStatusNm ?></span></div>

</div>
<div class="col-lg-6 col-md-12 col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Tempoh Lantikan:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= Yii::$app->formatter->format($model->startDateLantik, ['date', 'dd MMM Y']) ?> hingga <?= Yii::$app->formatter->format($model->endDateLantik, ['date', 'dd MMM Y']) ?></span></div>

</div>
<div class="col-lg-6 col-md-12 col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Status Pekerja:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>

</div>
<div class="col-lg-6 col-md-12 col-xs-12">

    <div class="col-lg-5 col-md-4 col-xs-4 "><span class="alignright"><b>Tarikh Mula Status:</b></span></div>
    <div class="col-lg-7 col-md-8 col-xs-8"><span ><?= Yii::$app->formatter->format($model->startDateStatus, ['date', 'dd MMM Y']) ?></span></div>

</div>


<div class="row">
    <!--/span-->
    <div class="col-md-4">
<?= $form->field($model, 'company_country', ['inputOptions' => ['class' => 'form-control']])
         ->dropDownList(ArrayHelper::map(app\modules\settings\models\Country::find()->all(),
         'country_id', 'country_name'),
          ['prompt' => Yii::t('app', 'Select Country')])->label(false) ?>
    </div>
    <!--/span-->
    <div class="col-md-4">
<?=
$form->field($model, 'company_state')->widget(DepDrop::classname(), [
    'data' => [$model->company_state => 'default'],
    'options' => ['id' => Html::getInputId($model, 'company_state'),
        'placeholder' => Yii::t('app', 'Select State')],
    'pluginOptions' => [
        'depends' => [Html::getInputId($model, 'company_country')],
        'initialize' => true,
        'url' => Url::to(['/settings/state/statelist'])
    ]
])->label(false)
?>
    </div>
    <!--/span-->
    <div class="col-md-4">
<?=
$form->field($model, 'company_city')->widget(DepDrop::classname(), [
    'data' => [$model->company_city => 'default'],
    'options' => ['id' => Html::getInputId($model, 'company_city'),
        'placeholder' => Yii::t('app', 'Select City')],
    'pluginOptions' => [
        'depends' => [Html::getInputId($model, 'company_state')],
        'initialize' => true,
        'url' => Url::to(['/settings/city/citylist'])
    ]
])->label(false)
?>
    </div>
    <!--/span-->
</div>




public function actionStatelist() {
$out = [];
if (isset($_POST['depdrop_parents'])) {
$parents = $_POST['depdrop_parents'];
if ($parents != null) {
$cat_id = $parents[0];
$out = State::find()->select(['id' => 'state_id','name'=>'state_name'])->where(['state_country_id'=>$cat_id])->asArray()->all();

echo Json::encode(['output'=>$out, 'selected'=>'']);
return;
}
}
echo Json::encode(['output'=>'', 'selected'=>'']);
}



public function actionCitylist() {
$out = [];
if (isset($_POST['depdrop_parents'])) {
$parents = $_POST['depdrop_parents'];
if ($parents != null) {
$cat_id = $parents[0];
$out = City::find()->select(['id' => 'city_id','name'=>'city_name'])->where(['city_state_id'=>$cat_id])->asArray()->all();

echo Json::encode(['output'=>$out, 'selected'=>'']);
return;
}
}
echo Json::encode(['output'=>'', 'selected'=>'']);
}