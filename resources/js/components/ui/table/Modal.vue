<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
    headers: string[];
    isAddMode: boolean;
}>();

defineEmits<{
    (e: 'close'): void;
    (e: 'submit', id: string, data: any): void;
}>();

const formData = ref<Record<string, any>>({});
</script>

<template>
    <div
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
        @click="$emit('close')"
    >
        <div
            class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md max-h-[80vh] overflow-y-auto"
            @click.stop
        >
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Update Row</h2>
            <form @submit.prevent="$emit('submit', formData.id, formData)">
                <div v-for="header in headers" :key="header" class="mb-4">
                    <label
                        :for="header"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 capitalize"
                    >
                        {{ header }}
                    </label>
                    <input
                        v-model="formData[header]"
                        :id="header"
                        type="text"
                        class="w-full px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                    />
                    <UploadBox v-if=""/>
                </div>
                <div class="flex justify-end space-x-3">
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition-all duration-200"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
