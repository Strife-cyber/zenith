<script setup lang="ts">
import { ref, watch, defineEmits, defineProps } from 'vue';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// Import Lucide Icons
import {
    Upload, Trash, Grid, List, FolderTree, File, Folder, X, CloudUpload
} from 'lucide-vue-next';

const props = defineProps<{
    files: File[];
}>();

const emit = defineEmits(['update:files']);

const filesList = ref<File[]>([...props.files]); // Local state to avoid direct prop mutation
const viewMode = ref('list');
const isDragging = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

// Emit updated file list to the parent
const updateFiles = () => {
    emit('update:files', filesList.value);
};

// Drag and drop handlers
const handleDragOver = (e: DragEvent) => {
    e.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = (e: DragEvent) => {
    e.preventDefault();
    isDragging.value = false;
};

const handleDrop = (e: DragEvent) => {
    e.preventDefault();
    isDragging.value = false;
    if (e.dataTransfer?.files.length) {
        filesList.value = [...filesList.value, ...Array.from(e.dataTransfer.files)];
        updateFiles();
    }
};

// File input handling
const openFilePicker = () => {
    fileInput.value?.click();
};

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files?.length) {
        filesList.value = [...filesList.value, ...Array.from(target.files)];
        updateFiles();
    }
};

// File handling functions
const handleDelete = (fileToRemove: File) => {
    filesList.value = filesList.value.filter((file) => file !== fileToRemove);
    updateFiles();

    Toastify({
        text: `${fileToRemove.name} removed from the list.`,
        duration: 2000,
        gravity: 'top',
        position: 'center',
        backgroundColor: '#FFC107',
    }).showToast();
};

// Tree View Logic
const treeStructure = ref<{ name: string; type: string; children: any[] }[]>([]);

const buildTree = (files: File[]) => {
    const tree: any[] = [];
    files.forEach((file) => {
        const pathParts = file.name.split('/');
        let currentLevel = tree;
        pathParts.forEach((part, index) => {
            const existingPath = currentLevel.find((item) => item.name === part);
            if (existingPath) {
                currentLevel = existingPath.children;
            } else {
                const newPart = {
                    name: part,
                    type: index === pathParts.length - 1 ? 'file' : 'folder',
                    children: [],
                };
                currentLevel.push(newPart);
                currentLevel = newPart.children;
            }
        });
    });
    return tree;
};

// Watch files and update tree structure
watch(filesList, (newFiles) => {
    treeStructure.value = buildTree(newFiles);
}, { immediate: true });
</script>

<template>
    <div class="flex items-center justify-between p-2">
        <!-- File Operation Buttons -->
        <div class="flex gap-2">
            <input
                type="file"
                ref="fileInput"
                multiple
                class="hidden"
                @change="handleFileUpload"
            />
            <Upload class="w-5 h-5 cursor-pointer text-gray-600 hover:text-blue-500" @click="openFilePicker" />
            <Trash class="w-5 h-5 cursor-pointer text-gray-600 hover:text-blue-500" @click="filesList = []; updateFiles()" />
        </div>

        <!-- View Mode Buttons -->
        <div class="flex gap-2">
            <Grid class="w-5 h-5 cursor-pointer text-gray-600 hover:text-blue-500" @click="viewMode = 'list'" />
            <List class="w-5 h-5 cursor-pointer text-gray-600 hover:text-blue-500" @click="viewMode = 'details'" />
            <FolderTree class="w-5 h-5 cursor-pointer text-gray-600 hover:text-blue-500" @click="viewMode = 'tree'" />
        </div>
    </div>

    <div
        class="relative h-[250px] w-full overflow-auto border-2 border-gray-100 p-4"
        @dragover.prevent="handleDragOver"
        @dragleave.prevent="handleDragLeave"
        @drop.prevent="handleDrop"
    >
        <div v-if="!filesList.length" class="absolute inset-0 flex flex-col items-center justify-center border-2 border-dashed border-gray-400 bg-gray-50">
            <CloudUpload class="w-12 h-12 text-gray-400" />
            <p class="mt-4 text-gray-600">Drag and drop files here or click to upload</p>
        </div>

        <!-- File List View -->
        <div v-if="viewMode === 'list' && filesList.length">
            <div v-for="(file, index) in filesList" :key="index" class="flex items-center gap-2 p-2 border">
                <File class="w-5 h-5 text-gray-500" />
                <span>{{ file.name }}</span>
                <X class="w-5 h-5 text-red-500 cursor-pointer" @click="handleDelete(file)" />
            </div>
        </div>

        <!-- Tree View -->
        <div v-if="viewMode === 'tree' && filesList.length">
            <div v-for="(item, index) in treeStructure" :key="index" class="ml-4">
                <div class="flex items-center">
                    <Folder v-if="item.type === 'folder'" class="w-5 h-5 text-gray-500" />
                    <File v-if="item.type === 'file'" class="w-5 h-5 text-gray-500" />
                    <span class="ml-2">{{ item.name }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
