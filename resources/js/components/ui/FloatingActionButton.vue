<template>
    <button class="fab" @click="handleClick">
        <span class="fab-icon">+</span>
    </button>
</template>

<script setup>
import { defineEmits } from 'vue'

const emit = defineEmits(['fab-clicked'])

const handleClick = () => {
    emit('fab-clicked')
}
</script>

<style scoped>
.fab {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background-color: #007bff;
    color: white;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fab-icon {
    font-size: 24px;
    font-weight: bold;
}
</style>
