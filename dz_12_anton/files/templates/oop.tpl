<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OOP</title>

    <!-- Bootstrap -->
   <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

  </head>
  <body style="width:500px;padding: 30px;">

    {include file='table.tpl.html'}
    
    
    <form class="form-horizontal" method="POST" role="form">
{*        <input type="hidden" name="id" value="1">*}
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Название</label>
    <div class="col-sm-10">
      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Название">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Описание</label>
    <div class="col-sm-10">
     <textarea name="desc" class="form-control" rows="3"></textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="radio">
  <label>
    <input type="radio" name="type" id="optionsRadios1" value="частное лицо" checked>
    Частное объявление
  </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="type" id="optionsRadios2" value="компания">
    Объявление Компании
  </label>
</div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Отправить</button>
    </div>
  </div>
</form>
    
   
  </body>
</html>