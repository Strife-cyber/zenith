<script setup lang="ts">
import { watch } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    message: String,
    active: Boolean,
});

watch(
    () => props.active,
    (newValue: string) => {
        if (newValue && props.message) {
            toast(props.message, {
                position: "top-right",
                autoClose: 3000,
                hideProgressBar: true,
                closeOnClick: true,
                pauseOnHover: true,
            })
        }
    }
);
</script>

<template>

</template>

<style scoped>

</style>
