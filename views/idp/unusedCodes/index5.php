<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">-->
<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>-->
<!--  <style>
  /* Popover */
  .popover {
    border: 2px dotted red;
  }
  /* Popover Header */
  .popover-title {
    background-color: #73AD21; 
    color: #FFFFFF; 
    font-size: 28px;
    text-align:center;
  }
  /* Popover Body */
  .popover-content {
    background-color: coral;
    color: #FFFFFF;
    padding: 25px;
  }
  /* Popover Arrow */
  .arrow {
    border-right-color: red !important;
  }
  </style>-->
</head>
<body>

<div class="container">
  <h3>Popover CSS Example</h3>
  <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
</div>

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>

</body>
</html>
