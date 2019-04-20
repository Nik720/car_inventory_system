<template>
    <div class="alert-div">
        <div :class="'alert alert-' + alertType" role="alert" v-if="alertType">
            <Strong>{{ alertType.toUpperCase() }}!</Strong> {{ alertMessage }}
        </div>
    </div>

</template>

<script>
    export default {
        props: ['alertMessage', 'alertType']
    }
</script>

<style scoped>
    .alert {
        position: fixed;
        width: 250px;
        right: 50px;
        top: 40px;
        z-index: 10001;
    }
</style>
