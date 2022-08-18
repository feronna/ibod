      <div id="form" class="container-items"><br>
                                 <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <?php $in=1; foreach ($modelsAddress as $i => $modelAddress): ?>
                                <div class="item"><!-- widgetBody -->
                                        <?php
                                            // necessary for update action.
                                            if (! $modelAddress->isNewRecord) {
                                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                            }
                                        ?>
                                        <td class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item"><span class="panel-title-address"><?= $in++ ?></span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]catatan")->textInput(['maxlength' => true, 'placeholder' => 'Nama', 'required' => true])->label(false) ?>
                                            </div>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </td>
                                    <td class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="baki"></label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]catatan_2")->textInput(['maxlength' => true, 'required' => true,'placeholder' => "Baki (RM)", 'type' => 'number', 'step'=>".01", 'min' => '0.00'])->label(false) ?>
                                            </div>
                                        </td>
                                </div>
                            <?php endforeach; ?>
                            </div>

