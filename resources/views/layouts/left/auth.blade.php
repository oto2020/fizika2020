<!-- required sections, section, userInfo!-->
<div name = "layouts.left.auth">
    @if ($role == null)
        <br>
        Войдите
        <div class="login-block">
            <form  method="post" action="/login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <span class="input-group-addon"></span>
                    <input name="email" type="text" class="form-control" placeholder="Ваш email" value="{{Session::get('login_email')}}">
                </div>

                <div class="form-group">
                    <span class="input-group-addon"></span>
                    <input name="password" type="password" class="form-control" placeholder="Ваш суперпароль">
                </div>
                <button class="btn btn-secondary btn-block" type="submit">ВОЙТИ</button>
            </form>
            <div class="login-links">
                <p class="text-center" style="color:red">Нет аккаунта? <br>
                    <a class="txt-brand" href="/register"><font color="#29aafe">Регистрируйся</font></a>
                </p>
            </div>
        </div>
        <br>

    @endif
</div>
