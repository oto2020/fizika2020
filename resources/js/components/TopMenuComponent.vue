<template>
    <!-- Десктопная версия !-->
    <div v-if="!isMobile">
        <nav class="top-navbar navbar navbar-expand-lg navbar-dark bg-dark">
            <!--СПИСОК ССЫЛОК В ВЕРХНРЕМ МЕНЮ-->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" v-bind:href="mainPageUri">Главная</a>
                </li>
                <li v-for="sect in this.sectionMenu" class="nav-item">
                    <a class="nav-link" v-bind:href="sect.uri">{{sect.name}}</a>
                </li>
            </ul>

            <!--ЕСЛИ ВОЙДЕНО-->
            <ul v-if="isAuth" class="navbar-nav ml-auto">
                <div class="row p-0">

                    <!--АВА ПОЛЬЗОВАТЕЛЯ-->
                    <div @click="hrefCabinet" v-on:mouseenter="userMouseEnter" v-on:mouseleave="userMouseLeave" class="col-auto">
                        <img v-bind:src="user.avatar_src" class="img-user-avatar-on-top-menu" alt="Аватар">
                    </div>

                    <!--ИМЯ ПОЛЬЗОВАТЕЛЯ + РОЛЬ-->
                    <div @click="hrefCabinet" v-on:mouseenter="userMouseEnter" v-on:mouseleave="userMouseLeave" class="col-auto text-white pl-0">
                        <h5> {{user.name}} </h5>
                        <h6 v-html="underText"></h6>
                    </div>

                    <!--КНОПКА ВЫХОД-->
                    <div v-on:mouseenter="logoutMouseEnter" v-on:mouseleave="logoutMouseLeave" class="col-auto">
                        <a v-bind:href="this.logoutRoute" onclick="return confirm ('Точно выйти?')">
                            <img v-bind:src="logoutButtonSrc" class="button-exit-on-top-menu" alt="Выход">
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
                        <img v-bind:src="user.avatar_src" class="img-user-avatar-on-top-menu" alt="Аватар">
                    </a>
                </div>
                <!-- ВЫХОД -->
                <div v-if="isAuth" class="col">
                    <a class="float-right" href="/logout" onclick="return confirm ('Точно выйти?')">
                        <img v-bind:src="logoutButtonSrc" class="button-exit-on-top-menu" alt="Выход">
                    </a>
                </div>
            </div>
            <!-- СПИСОК В ВЕРХНЕМ МЕНЮ -->
            <div v-show="isVisibleList" class="row top-navbar navbar navbar-expand-lg navbar-dark bg-dark">
                <ul class="navbar-nav mr-auto pl-3">
                    <li class="nav-item">
                        <a class="nav-link" v-bind:href="mainPageUri">Главная</a>
                    </li>
                    <li v-for="sect in this.sectionMenu" class="nav-item">
                        <a class="nav-link" v-bind:href=sect.uri>{{sect.name}}</a>
                    </li>
                </ul>
            </div>
        </div>


    </div>


</template>

<script>
    export default {
        props: ['sections', 'user', 'role', 'school', 'registerRoute', 'loginRoute', 'logoutRoute'],
        data: function () {
            return {
                isAuth: !(this.user === null),
                isMobile: this.$isMobile(),
                // текст под Именем пользователя (будет изменяться на "Личный кабинет" при наведении)
                underText: '[' + ((this.role)?this.role.name:'') + ']',
                // путь к изображению кнопки выхода
                logoutButtonSrc: '/storage/img/main/exit_button.png',
                // будет ли список отображаться (в мобильной версии)
                isVisibleList: false,
                // uri главной страницы той школы, к которой принадлежит пользователь
                mainPageUri: this.school!==null ? '/' + this.school.uri : '/school0',
                // uri разделов в верхнем меню
                sectionMenu: [],
            }
        },
        methods: {
            userMouseEnter(event) {
                event.target.style.cursor = 'pointer';
                this.underText = '&#9733; [личный кабинет]';
            },
            userMouseLeave(event) {
                event.target.style.cursor = 'default';
                this.underText = '[' + this.role.name + ']';
            },

            logoutMouseEnter() {
                this.logoutButtonSrc= '/storage/img/main/exit_button_action.png';
            },
            logoutMouseLeave() {
                this.logoutButtonSrc= '/storage/img/main/exit_button.png';
            },

            hrefCabinet() {
                window.location.href = 'cabinet';
            }
        },

        mounted() {
            console.log('Top Menu mounted.');
            console.log('isAuth: ' + this.isAuth);
            console.log('isMobile: ' + this.isMobile);

            // заполняем список пунктов верхнего меню
            this.sectionMenu = [];
            for (let index = 0; index <  this.sections.length; index++) {
                this.sectionMenu.push(
                    {
                        name: this.sections[index].name,
                        uri: '/' +this.school.uri + '/' + this.sections[index].uri
                    }
                );
            }
        }
    }
</script>
