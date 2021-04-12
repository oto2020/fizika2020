<!DOCTYPE html>
<html lang = "ru">
<head>
    <title>Загрузка картинки</title>
    <link rel="icon" href="/storage/img/main/favicon.ico" type="image/x-icon">
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{asset('/css/app.css')}}" rel="stylesheet" type="text/css">
</head>
<body>

@include('layouts.messages.message')
<div class="container">
    <h1>Загрузка картинки</h1>
</div>


<div class="col-6" style="padding-left:3%">
    <form name="test" method="post" action="/img_upload.php" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div id="fileInputContainer">
            <div class="form-group">
                <b>Название файлов (префикс):</b>
                <input name="prepend_name" class="form-control" type="text" value="{{$prependName}}">
                <input type="file"  name="images[]" style="margin-top:4px;" accept=".jpg, .jpeg, .png, .bmp .gif" multiple>
            </div>
        </div>

        <div class="row alert alert-secondary" role="alert">
            <div class="col-8">
                (Принимаются файлы с разрешением <i>.jpg, .jpeg, .png, .bmp .gif</i>)
            </div>
            <div class="col-4">
                <input  class="btn btn-outline-success btn-lg btn-block" style="float:right;" type="submit" value="Загрузить">
            </div>
        </div>
        <br>
    </form>
</div>

<!-- КОНЕЦ Содержимого страницы!-->

<!-- СКРИПТ ПО АВТООБНОВЛЕНИЮ HTML-КОНТЕНТА!-->
<script>
    // получим ссылки на поля textarea
    let htmlContent = document.getElementById("html_content");
    let htmlContentView = document.getElementById("html_content_view");
    htmlContent.onkeyup = function(e){htmlContentView.innerHTML = htmlContent.value;};
</script>
<!-- КОНЕЦ СКРИПТ ПО АВТООБНОВЛЕНИЮ HTML-КОНТЕНТА!-->


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>




</body>
</html>
