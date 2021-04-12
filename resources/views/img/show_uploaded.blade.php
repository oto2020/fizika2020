<!DOCTYPE html>
<html lang = "ru">
<head>
    <title>Загруженные изображения</title>
    <link rel="icon" href="/storage/img/main/favicon.ico" type="image/x-icon">
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{asset('/css/app.css')}}" rel="stylesheet" type="text/css">
</head>
<body>

    @include('layouts.messages.message')

    <h1 class="ml-2">Загруженные изображения</h1>

    <div>
        @foreach($filePaths as $key => $path)
            <div>
                <div class="row">
                    <div class="col-6">
                        <img class="img-fluid img-thumbnail mb-2 w-25" src="{{$path}}">
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-12">
                        <input class="form-control w-100" id="path_{{$key}}" value="{{$path}}">
                    </div>
                    <div class="col-3">
                        <button type="button" onclick="copyToClipBoard({{$key}})" class="btn btn-primary" id="button_{{$key}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1h-2z"></path>
                                <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 1.707V10.5a.5.5 0 0 1-1 0V1.707L5.354 3.854a.5.5 0 1 1-.708-.708l3-3z"></path>
                            </svg>
                            Скопировать
                        </button>
                    </div>
                </div>
                <hr>
            </div>
        @endforeach
        <script>
            // копирует содержимое текстбокса в буфер обмена
            function copyToClipBoard(key) {
                let copyText = document.getElementById('path_' + key);
                copyText.select();
                document.execCommand("copy");
                alert("Скопирована ссылка: \n" + copyText.value + "\n\nИспользуйте её как url при размещении изображения на сайте.");
            }
        </script>
    </div>
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
