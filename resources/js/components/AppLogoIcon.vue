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
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" :class="className" v-bind="$attrs">
        <!-- Outer Circle (Sun) -->
        <circle cx="24" cy="24" r="10" fill="orange" stroke="gold" stroke-width="2" />

        <!-- Rays -->
        <g stroke="gold" stroke-width="2">
            <line x1="24" y1="4" x2="24" y2="12" />
            <line x1="24" y1="36" x2="24" y2="44" />
            <line x1="4" y1="24" x2="12" y2="24" />
            <line x1="36" y1="24" x2="44" y2="24" />
            <line x1="9" y1="9" x2="15" y2="15" />
            <line x1="33" y1="9" x2="39" y2="15" />
            <line x1="9" y1="39" x2="15" y2="33" />
            <line x1="33" y1="39" x2="39" y2="33" />
        </g>
    </svg>
</template>
