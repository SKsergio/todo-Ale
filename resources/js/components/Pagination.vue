<template>
    <div v-if="links.length > 3" class="pagination">
        <p class="pagination__info">
            Mostrando {{ from ?? 0 }}–{{ to ?? 0 }} de {{ total }}
        </p>

        <div class="pagination__pages">
            <template v-for="(link, index) in links" :key="index">
                <span v-if="link.url === null" class="pagination__link pagination__link--disabled"
                    v-html="link.label" />
                <Link v-else :href="link.url" preserve-scroll class="pagination__link"
                    :class="{ 'pagination__link--active': link.active }" v-html="link.label" />
            </template>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { PaginationLink } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: PaginationLink[];
    from: number | null;
    to: number | null;
    total: number;
}>();
</script>
