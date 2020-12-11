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

            <ul v-if="this.user!==null" class="navbar-nav ml-auto">
                <div>

                    <table>
                        <tr>
                            <!--АВА ПОЛЬЗОВАТЕЛЯ-->
                            <td id="user_ava_block">
                                <img :src="this.user.avatar_src" class="img-user-avatar-on-top-menu" alt="">
                            </td>
                            <!--ИМЯ ПОЛЬЗОВАТЕЛЯ + РОЛЬ-->
                            <td id="user_block">
                                <div class="text-white">
                                    <h5> {{this.user.name}} </h5>
                                    <h6> {{this.role.name}} </h6>
                                </div>
                            </td>
                            <!--КНОПКА ВЫХОД-->
                            <td>
                                <a href="/logout" onclick="return confirm ('Точно выйти?')">
                                    <img :src="'/storage/img/main/exit_button.png'" class="button-exit-on-top-menu"
                                         alt="">
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </ul>
            <ul v-else class="navbar-nav mr-auto">
                <div class="text-white">
                    <li class="nav-item">Регистрация</li>
                    <li class="nav-item">Вход</li>
                </div>
            </ul>
        </nav>
    </div>


</template>

<script>
    export default {
        props: ['user', 'role', 'message'],


        mounted() {
            console.log('Top Menu mounted.')
        }
    }
</script>
