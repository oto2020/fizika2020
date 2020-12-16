<template>
    <!--require sections, section !-->

    <!-- Десктопная версия !-->
    <div v-if="!isMobile">
        <nav class="top-navbar navbar navbar-expand-lg navbar-dark bg-dark">
            <!--СПИСОК ССЫЛОК В ВЕРХНРЕМ МЕНЮ-->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/main">Главная</a>
                </li>
                <li v-for="section in this.sections" class="nav-item">
                    <a class="nav-link" v-bind:href=section.url>{{section.name}}</a>
                </li>
            </ul>

            <!--ЕСЛИ ВОЙДЕНО-->
            <ul v-if="isAuth" class="navbar-nav ml-auto">
                <div class="row p-0">

                    <!--АВА ПОЛЬЗОВАТЕЛЯ-->
                    <div v-on:mouseenter="userMouseEnter" v-on:mouseleave="userMouseLeave" class="col-auto">
                        <img :src="this.user.avatar_src" class="img-user-avatar-on-top-menu" alt="Аватар">
                    </div>

                    <!--ИМЯ ПОЛЬЗОВАТЕЛЯ + РОЛЬ-->
                    <div id="userInfo" class="col-auto text-white">
                        <h5> {{this.user.name}} </h5>
                        <h6> {{this.role.name}} </h6>
                    </div>

                    <!--КНОПКА ВЫХОД-->
                    <div class="col-auto">
                        <a href="/logout" onclick="return confirm ('Точно выйти?')">
                            <img :src="'/storage/img/main/exit_button.png'" class="button-exit-on-top-menu" alt="Выход">
                        </a>
                    </div>
                </div>
            </ul>

            <!--ЕСЛИ НЕ ВОЙДЕНО-->
            <div v-else class="row">
                <div class="col-auto p-0">
                    <a v-bind:href=this.registerRoute class="btn btn-secondary"> Регистрация </a>
                </div>
                <div class="col-auto">
                    <a v-bind:href=this.loginRoute class="btn btn-secondary"> Вход </a>
                </div>
            </div>
        </nav>
    </div>
    <!--Мобильная версия-->
    <div v-else>
        <div>
            <!-- /|\ КНОПКА /|\ АВАТАР /|\ ВЫХОД /|\ -->
            <div class="row top-navbar navbar navbar-expand-lg navbar-dark bg-dark">
                <!-- КНОПКА МЕНЮ -->
                <div v-on:click="isVisibleList=!isVisibleList" class="col">
                    <img class="float-left img-user-avatar-on-top-menu" src="/storage/img/main/menu_button.png">
                </div>
                <!-- АВАТАР ПОЛЬЗОВАТЕЛЯ !-->
                <div v-if="isAuth" class="col text-center">
                    <a href="/cabinet">
                        <img :src="this.user.avatar_src" class="img-user-avatar-on-top-menu" alt="Аватар">
                    </a>
                </div>
                <!-- ВЫХОД -->
                <div v-if="isAuth" class="col">
                    <a class="float-right" href="/logout" onclick="return confirm ('Точно выйти?')">
                        <img :src="'/storage/img/main/exit_button.png'" class="button-exit-on-top-menu" alt="Выход">
                    </a>
                </div>
            </div>
            <!-- СПИСОК В ВЕРХНЕМ МЕНЮ -->
            <div v-show="isVisibleList" class="row top-navbar navbar navbar-expand-lg navbar-dark bg-dark">
                <ul class="navbar-nav mr-auto pl-3">
                    <li class="nav-item">
                        <a class="nav-link" href="/main">Главная</a>
                    </li>
                    <li v-for="section in this.sections" class="nav-item">
                        <a class="nav-link" v-bind:href=section.url>{{section.name}}</a>
                    </li>
                </ul>
            </div>
        </div>


    </div>


</template>

<script>
    export default {
        props: ['sections', 'user', 'role', 'registerRoute', 'loginRoute'],
        data: function () {
            return {
                isAuth: !(this.user === null),
                isMobile: this.$isMobile(),
                // будет ли список отображаться
                isVisibleList: false,
            }
        },
        methods: {
            userMouseEnter() {
                //console.log(this);
                //this.style.cursor = 'innerhit';
            },
            userMouseLeave() {
                //this.style.cursor = '';
            },
        },

        mounted() {
            console.log('Top Menu mounted.');
            console.log('isAuth: ' + this.isAuth);
            console.log('isMobile: ' + this.isMobile);
        }
    }
</script>
