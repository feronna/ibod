<!DOCTYPE html>
<html>
    <style>
        #myProgress {
            width: 100%;
            background-color: #ddd;
        }

        #myBar {
            width: 0%;
            height: 30px;
            background-color: #172D44;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.25) inset;
            text-align: center;
            color: white;
            justify-content: center;
        }
    </style>
    <body>

        <div id="myProgress">
            <div align="center" class="progress progress-striped active text-center" id="myBar"></div>
        </div>
        <div id="status" align="center">Generating Document.......</div>
        <br>
        <script>
            var data = sessionStorage.getItem('checkedcv');
            var icno1 = data.split(',');
            var count = icno1.length;
            var progress = 100 / count;
            var icno = data;
            window.onload = function () {
                codeAddress(1, progress);
            };
            var elem = document.getElementById("myBar");
            var gred = "<?= $gred ?>";
            function codeAddress(val, width) {
                if (val <= count) {
                    $.ajax({
                        timeout: 0,
                        url: "laporan?row=" + val + "&&icno=" + icno + "&&gred=" + gred,
                        success: function (data) {
                            elem.style.width = width + '%';
                            elem.textContent = Math.round(width, 2) + '%';
                            codeAddress(val + 1, width + progress);
                        }
                    });

                }
                else {
                    elem.style.width = '100%';
                    if (gred != 13) {
                        window.location.href = '/staff/web/uploads-cv/laporan.xlsx';
                    } else {
                        window.location.href = '/staff/web/uploads-cv/laporan-DS52.xlsx';
                    }
                    document.getElementById("status").textContent = 'Document Downloaded';
                }
                ;

        //    if (progress >= 100) {
        //      clearInterval(id);
        //    } else {
        //      elem.style.width = progress + '%'; 
        //    }
            }
            ;
        </script>
    </body>
</html>
