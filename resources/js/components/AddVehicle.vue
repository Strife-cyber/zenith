<script setup lang="ts">
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu';
import UploadBox from '@/components/ui/table/UploadBox.vue';
import { router } from '@inertiajs/vue3';
import Toastify from 'toastify-js';

const form = ref({
    title: '',
    description: '',
    category: 'car',
    type: '', // For Property Type
    price: 0,
    status: 'available',
    images: [] as File[],
    make: '',
    model: '',
    year: '',
    fuel: '', // For Fuel Type
    transmission: '', // For Transmission Type
    condition: '', // For Condition
});

// Handle Property Type selection
const setType = (type: string) => {
    form.value.type = type;
};

// Handle Fuel Type selection
const setFuel = (fuel: string) => {
    form.value.fuel = fuel;
};

// Handle Transmission Type selection
const setTransmission = (transmission: string) => {
    form.value.transmission = transmission;
};

// Handle Condition selection
const setCondition = (condition: string) => {
    form.value.condition = condition;
};

const submit = () => {
    router.post('/vehicles', form.value, {
        onSuccess: () => {
            Toastify({
                text: 'New vehicle registered and put for sale or rent',
                duration: 2000,
                gravity: 'top',
                position: 'top-left',
            }).showToast();
        },
        onError: (error) => {
            Toastify({
                text: `Error: ${error.message}`,
                duration: 2000,
                gravity: 'top',
                position: 'top-left',
                backgroundColor: 'red'
            }).showToast();
        }
    });
};
</script>

<template>
    <div class="form-container bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg transition-all duration-300">
        <form @submit.prevent="submit" class="form space-y-6">
            <!-- Title -->
            <div class="input-group">
                <label for="title" class="input-label">Title</label>
                <Input
                    v-model="form.title"
                    id="title"
                    placeholder="Enter listing title"
                    class="w-full"
                />
            </div>

            <!-- Description -->
            <div class="input-group">
                <label for="description" class="input-label">Description</label>
                <Input
                    v-model="form.description"
                    id="description"
                    placeholder="Enter listing description"
                    class="w-full"
                />
            </div>

            <!-- Property Type Dropdown -->
            <div class="input-group">
                <label class="input-label">Property Type</label>
                <DropdownMenu>
                    <DropdownMenuTrigger class="dropdown-trigger">
                        {{ form.type || 'Select Type' }}
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="dropdown-content">
                        <DropdownMenuItem @click="setType('rent')">
                            Rent
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="setType('sale')">
                            Sale
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <!-- Price -->
            <div class="input-group">
                <label for="price" class="input-label">Price</label>
                <Input
                    v-model.number="form.price"
                    id="price"
                    type="number"
                    placeholder="Enter price"
                    class="w-full"
                />
            </div>

            <!-- Make -->
            <div class="input-group">
                <label for="make" class="input-label">Make</label>
                <Input
                    v-model="form.make"
                    id="make"
                    placeholder="Enter make"
                    class="w-full"
                />
            </div>

            <!-- Model -->
            <div class="input-group">
                <label for="model" class="input-label">Model</label>
                <Input
                    v-model="form.model"
                    id="model"
                    placeholder="Enter model"
                    class="w-full"
                />
            </div>

            <!-- Year -->
            <div class="input-group">
                <label for="year" class="input-label">Year</label>
                <Input
                    v-model="form.year"
                    id="year"
                    placeholder="Enter production year"
                    class="w-full"
                />
            </div>

            <!-- Fuel Type Dropdown -->
            <div class="input-group">
                <label class="input-label">Fuel Type</label>
                <DropdownMenu>
                    <DropdownMenuTrigger class="dropdown-trigger">
                        {{ form.fuel || 'Select Fuel Type' }}
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="dropdown-content">
                        <DropdownMenuItem @click="setFuel('petrol')">
                            Petrol
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="setFuel('diesel')">
                            Diesel
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="setFuel('electric')">
                            Electric
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <!-- Transmission Type Dropdown -->
            <div class="input-group">
                <label class="input-label">Transmission Type</label>
                <DropdownMenu>
                    <DropdownMenuTrigger class="dropdown-trigger">
                        {{ form.transmission || 'Select Transmission Type' }}
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="dropdown-content">
                        <DropdownMenuItem @click="setTransmission('manual')">
                            Manual
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="setTransmission('automatic')">
                            Automatic
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <!-- Condition Dropdown -->
            <div class="input-group">
                <label class="input-label">Condition</label>
                <DropdownMenu>
                    <DropdownMenuTrigger class="dropdown-trigger">
                        {{ form.condition || 'Select Condition' }}
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="dropdown-content">
                        <DropdownMenuItem @click="setCondition('new')">
                            New
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="setCondition('used')">
                            Used
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <!-- Images -->
            <div class="input-group">
                <label class="input-label">Images</label>
                <UploadBox v-model:files="form.images" accept="image/*" multiple />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-button">
                Submit Vehicle
            </button>
        </form>
    </div>
</template>

<style scoped>
.form-container {
    max-width: 600px;
    margin: auto;
    padding: 1.5rem;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.input-group {
    margin-bottom: 1.5rem;
}

.input-label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #374151; /* Gray-700 */
    transition: color 0.3s ease-in-out;
}

.dark .input-label {
    color: #f3f4f6; /* Gray-100 */
}

.dropdown-trigger {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0; /* Gray-200 */
    border-radius: 0.5rem;
    background-color: white;
    text-align: left;
    cursor: pointer;
    color: #374151; /* Gray-700 */
    transition: all 0.3s ease-in-out;
}

.dark .dropdown-trigger {
    border-color: #4b5563; /* Gray-600 */
    background-color: #1f2937; /* Gray-800 */
    color: #f3f4f6; /* Gray-100 */
}

.dropdown-trigger:hover {
    border-color: #cbd5e1; /* Gray-300 */
}

.dark .dropdown-trigger:hover {
    border-color: #6b7280; /* Gray-500 */
}

.dropdown-content {
    background-color: white;
    border: 1px solid #e2e8f0; /* Gray-200 */
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 0.5rem;
    animation: slideDown 0.2s ease-in-out;
}

.dark .dropdown-content {
    background-color: #1f2937; /* Gray-800 */
    border-color: #4b5563; /* Gray-600 */
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.submit-button {
    width: 100%;
    padding: 0.75rem 1.5rem;
    background-color: #3b82f6; /* Blue-500 */
    color: white;
    border-radius: 0.5rem;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.submit-button:hover {
    background-color: #2563eb; /* Blue-600 */
    transform: translateY(-1px);
}

.submit-button:active {
    transform: translateY(0);
}

.dark .submit-button {
    background-color: #1d4ed8; /* Blue-700 */
}

.dark .submit-button:hover {
    background-color: #1e40af; /* Blue-800 */
}
</style>
