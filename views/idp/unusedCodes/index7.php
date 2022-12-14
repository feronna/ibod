<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link href="//cdn.rawgit.com/twbs/bootstrap/v4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="dist/css/bootstrap-colorpicker.css" rel="stylesheet">
</head>
<body>
  <div class="jumbotron">
      <h1>Bootstrap Colorpicker Demo</h1>
      <input id="demo" type="text" class="form-control" value="rgb(255, 128, 0)" />
  </div>
  <script src="//code.jquery.com/jquery-3.3.1.js"></script>
  <script src="//cdn.rawgit.com/twbs/bootstrap/v4.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/bootstrap-colorpicker.js"></script>
  <script>
    $(function () {
      // Basic instantiation:
      $('#demo').colorpicker();
      
      // Example using an event, to change the color of the .jumbotron background:
      $('#demo').on('colorpickerChange', function(event) {
        $('.jumbotron').css('background-color', event.color.toString());
      });
    });
  </script>
</body>
