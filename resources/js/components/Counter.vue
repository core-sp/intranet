<template>
    <div class="counter">
        <h5 class="mb-0">
            <span :class="classes">{{ this.$attrs.count }}</span>
        </h5>
    </div>
</template>

<script>
    export default {
        computed: {
            classes: function() {
                return this.$attrs.classes;
            }
        }
    }
</script>

<style>
    .counter {
        display: inline-block;
    }
</style>
