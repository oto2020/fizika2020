<template>
    <div>
        <p>Это шаблон компонента</p>
        <div class="row">
            <div class="col-2">
                <row>
                    <button v-for="unit in units" type="button" class="btn btn-outline-info btn-block button-calc-unit my-1">{{unit.name}}</button>
                </row>
            </div>
            <div class="col-10"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['units'],
        mounted() {
            console.log('Example component mounted.')
        }
    }
</script>
