  <?php if ($biodata->akademik) { ?>
                          
                            <ul class="list-unstyled timeline widget">
                                <?php
                                foreach ($biodata->akademik as $akademik) {
                                    ?> 
                                    <li><div class="block">
                                            <div class="block-content">
                                                <h2 class="title">
                                                    <?php
                                                    echo $akademik->EduCertTitle . ', ';
                                                    if ($akademik->InstCd == 004) {
                                                        echo 'Lain-Lain';
                                                    } else {
                                                        echo $akademik->institut ? $akademik->institut->InstNm : '';
                                                    }
                                                    ?></h2>
                                                <div class="byline">
                                                    <big><span>Graduation Date: </span> <a><?= $biodata->getTarikh($akademik->ConfermentDt); ?></a> <br/>
                                                        <span>Major: </span> <a><?= $akademik->major ? $akademik->major->MajorMinor : 'Tiada Maklumat'; ?></a>  
                                                    </big>
                                                </div>
                                                <div class="excerpt"> <b>Grade:</b> <?= $akademik->OverallGrade ? $akademik->OverallGrade : 'Tiada Maklumat'; ?> </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>   
                     
                    <?php } ?>