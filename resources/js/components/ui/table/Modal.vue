<script setup lang="ts">
import { ref, watch } from 'vue';
import UploadBox from '@/components/ui/table/UploadBox.vue';

const props = defineProps<{
    data?: Record<string, any>; // Existing data for update mode
    headers: string[];
    isAddMode: boolean;
    onSubmit?: (formData: Record<string, any>) => void;
    handleCancel?: () => void;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'submit', id: string | undefined, data: Record<string, any>): void;
}>();

// Reactive references
const files = ref<File[]>([]);
// Initialize formData with empty object or existing data
const formData = ref<Record<string, any>>({});

// Watch for changes in props.data and isAddMode to update formData
watch(
    () => [props.data, props.isAddMode],
    ([newData, newIsAddMode]) => {
        if (!newIsAddMode && newData) {
            // Update mode: populate form with existing data
            formData.value = { ...newData };
        } else {
            // Add mode: reset form
            formData.value = {};
        }
    },
    { immediate: true } // Run immediately when component mounts
);

function handleSubmit(event: Event) {
    event.preventDefault();

    // Create detailed file info for logging
    const fileDetails = files.value.map(file => ({
        name: file.name,
        size: file.size,
        type: file.type,
        lastModified: file.lastModified,
    }));

    console.log('Form Data Submitted:', {
        id: formData.value.id,
        data: { ...formData.value },
        files: fileDetails,
        isAddMode: props.isAddMode
    });

    if (props.onSubmit) {
        props.onSubmit({ ...formData.value });
    }

    emit('submit', formData.value.id, { ...formData.value });
}

function onCancel() {
    if (props.handleCancel) {
        props.handleCancel();
    }
    emit('close');
}
</script>

<template>
    <div
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
        @click="onCancel"
    >
        <div
            class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md max-h-[80vh] overflow-y-auto"
            @click.stop
        >
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ isAddMode ? 'Add Row' : 'Update Row' }}
            </h2>
            <form @submit="handleSubmit">
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
                </div>
                <UploadBox v-if="isAddMode" v-model:files="files" />
                <div class="flex justify-end space-x-3 mt-3">
                    <button
                        type="button"
                        @click="onCancel"
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
