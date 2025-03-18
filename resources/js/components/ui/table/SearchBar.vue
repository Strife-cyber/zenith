<script setup lang="ts">
defineProps<{
    modelValue: string;
}>();
defineEmits(['update:modelValue']);
</script>

<template>
    <div class="p-4 border-b border-gray-200 dark:border-gray-800">
        <div class="relative">
            <input
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                type="text"
                placeholder="Search..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
            />
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
</template>
