<template>
    <nav aria-label="breadcrumb" class="flex-one">
        <ol class="breadcrumb mb-0">
            <slot></slot>
        </ol>
    </nav>
</template>

<style>
    .flex-one {
        flex: 1;
    }
</style>