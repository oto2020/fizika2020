<template>
    <!--require sections, section !-->

    <!-- Десктопная версия !-->
    <div>
        <nav class="top-navbar navbar navbar-expand-lg navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/main">Главная</a>
                </li>
            </ul>

            <!--ЕСЛИ ВОЙДЕНО-->
            <ul v-if="this.user!==null" class="navbar-nav ml-auto">
                <div class="row">

                    <!--АВА ПОЛЬЗОВАТЕЛЯ-->
                    <div v-on:mouseenter="userMouseEnter" v-on:mouseleave="userMouseLeave" class="col-auto" >
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


</template>

<script>
    export default {
        props: ['user', 'role', 'registerRoute', 'loginRoute'],
        methods: {
            userMouseEnter() {
                console.log(this);
                this.style.cursor ='innerhit';
            },
            userMouseLeave() {
                this.style.cursor ='';
            },
        },

        mounted() {
            console.log('Top Menu mounted.')
        }
    }
</script>
