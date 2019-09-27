<template>
    <form @submit.prevent="onSubmit">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        methods: {
            onSubmit() {
                if(this.$attrs.hasrespondent == '') {
                    alert('Por favor, atribua o chamado à algum usuário antes de concluí-lo.');
                    return false;
                } else {
                    this.$el.submit();
                }
            }
        }
    }
</script>