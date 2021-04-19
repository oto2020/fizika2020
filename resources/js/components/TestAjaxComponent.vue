<template>
    <div class="container">
        <!-- HTML-форма, оформленная с помощью стилей Bootstrap 4 -->
        <form method="post" action="#" autocomplete="off">
            <div class="form-group">
                <input
                    name="email"
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Введите email"
                    v-model="login"
                >
            </div>
            <div class="form-group">
                <input
                    name="password"
                    type="password"
                    class="form-control"
                    id="password"
                    placeholder="Введите пароль"
                    v-model="password"
                >
            </div>
            <button type="submit" class="btn btn-primary" @click="myMethod($event)">Войти</button>
        </form>

<!--            <form name="test" method="post" action="#" enctype="multipart/form-data">-->
<!--                <div id="fileInputContainer">-->
<!--                    <div class="form-group">-->
<!--                        <b>Название файлов (префикс):</b>-->
<!--                        <input name="prepend_name" class="form-control" type="text" v-model="prependName">-->
<!--                        <input type="file" accept="image/*" id="file-input">-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="row alert alert-secondary" role="alert">-->
<!--                    <div class="col-8">-->
<!--                        (Принимаются файлы с разрешением <i>.jpg, .jpeg, .png, .bmp .gif</i>)-->
<!--                    </div>-->
<!--                    <div class="col-4">-->
<!--                        <input @click="uploadImage($event)" class="btn btn-outline-success btn-lg btn-block" type="submit" value="Загрузить">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <br>-->
<!--            </form>-->
    </div>
</template>

<script>
    export default {
        // получаем из контроллера
        props: ['prependName'],

        data: function () {
            return {
                login: '',
                password: '',
                output: 'неизменно'
            }
        },
        methods: {
            async myMethod(e) {
                e.preventDefault();
                let currentObj = this;
                this.axios.post('/test_post_ajax.php', {
                    login: this.login,
                    password: this.password
                }).
                then(function (response) { console.log(response.data); }).
                catch(function (error) { currentObj.output = error; });
            }

            // uploadImage(event) {
            //     e.preventDefault();
            //
            //
            //     let data = new FormData();
            //     data.append('prepend_name', this.prepend_name);
            //     data.append('images', event.target.files);
            //
            //
            //     let currentObj = this;
            //     this.axios.post('/img_upload.php', {
            //         prepend_name: this.prepend_name,
            //         images: event.target.files
            //     }
            //     ).
            //     then(function (response) { console.log(response.data); }).
            //     catch(function (error) { currentObj.output = error; });
            //
            //     // axios.post(
            //     //     URL,
            //     //     data,
            //     //     config
            //     // ).then(
            //     //     response => {
            //     //         console.log('image upload response > ', response)
            //     //     }
            //     // )
            // }

        },
        mounted() {
            clear();
            console.log('Example component mounted.')
        }
    }
</script>
