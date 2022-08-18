
<?php


use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        
        'attributes' => [
            [                  
                'label' => 'IC/KP',
                'value' => $model->icno,
            ],
            [                  
                'label' => 'Nama Pengguna',
                'value' => $model->name,
            ],
            [                  
                'label' => 'Jenis Notifikasi',
                'value' => function($model){
                    switch ($model->mp_type) {
                        case '1':
                            return 'Paspot';
                            break;
                        case '2':
                            return 'Permit Kerja';
                            break;
                        
                        default:
                            return '-';
                            break;
                    }
                },
            ],
            [                  
                'label' => 'Tajuk Notifikasi',
                'value' => $model->reminder_title,
            ],
            [                  
                'label' => 'Sebab Notifikasi',
                'value' => $model->reminder_reason,
            ],
            [                  
                'label' => 'Tarikh Notifikasi',
                'value' => $model->entry_dt,
            ],
            [                  
                'label' => 'Tarikh Terkini Notifikasi',
                'value' => $model->alter_dt,
            ],
            [                  
                'label' => 'Kekerapan Notifikasi',
                'value' => function($model){
                    return $model->reminder_counter . ' kali';
                },
                'format'=>'raw',
            ],
            [                  
                'label' => 'Status Notifikasi',
                'value' => function($model){
                    if($model->reminder_status == '1'){
                        return 'Aktif';
                    }
                    return 'Tidak Aktif';
                },
                'format'=>'raw',
            ],
            [                  
                'label' => 'Tarikh Mula Notifikasi',
                'value' => $model->mp_effective_dt,
            ],
            [                  
                'label' => 'Tarikh Tamat Notifikasi',
                'value' => $model->mp_expiry_dt,
            ],
            
        ],
    ]); ?>
