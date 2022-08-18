echo FileInput::widget([
        'model' => $model,
        'attribute' => 'upload_image',
        'pluginOptions' => [
            'initialPreview'=>[
                Html::img("/uploads/" . $model->image)
            ],
            'overwriteInitial'=>true
        ]
    ]);