<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img src="../../img/gojocinamonrol.png" class="image_login_logo">
</template>

<style scoped>
    .image_login_logo{
        width: 100%;
    }
</style>
