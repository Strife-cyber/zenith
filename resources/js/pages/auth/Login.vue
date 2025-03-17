<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase
        title="Welcome Back to Zenith"
        description="Log in with your credentials to access your estate journey"
        class="relative min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-orange-900/20 flex items-center justify-center">
        <Head title="Log in" />

        <!-- Decorative Background SVG -->
        <div class="absolute inset-0 z-0 opacity-10 pointer-events-none animate-pulse">
            <svg class="w-full h-full" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 20L180 80V180H20V80L100 20Z" stroke="#f97316" stroke-width="2"/>
                <path d="M80 120H120V180H80V120Z" fill="#f97316" fill-opacity="0.2"/>
            </svg>
        </div>

        <!-- Form Container -->
        <div class="relative z-10 w-full max-w-md p-8 bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-2xl
                    shadow-orange-500/20 border border-gray-700/50 animate-fadeIn">
            <!-- Status Message -->
            <div v-if="status" class="mb-6 text-center text-sm font-medium text-orange-400 bg-orange-900/20
                                     py-2 px-4 rounded-md animate-slideUp">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <!-- Email Field -->
                    <div class="grid gap-2">
                        <Label for="email" class="text-gray-200 font-semibold">Email Address</Label>
                        <Input
                            id="email"
                            type="email"
                            required
                            autofocus
                            :tabindex="1"
                            autocomplete="email"
                            v-model="form.email"
                            placeholder="email@example.com"
                            class="bg-gray-700 text-gray-200 border-gray-600 focus:border-orange-400
                                   focus:ring-2 focus:ring-orange-400/50 rounded-md py-3 px-4
                                   transition-all duration-300 hover:bg-gray-600"/>
                        <InputError :message="form.errors.email" class="text-orange-400 text-xs"/>
                    </div>

                    <!-- Password Field -->
                    <div class="grid gap-2">
                        <div class="flex items-center justify-between">
                            <Label for="password" class="text-gray-200 font-semibold">Password</Label>
                            <TextLink
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm text-orange-400 hover:text-orange-500 transition-all duration-300
                                       hover:scale-105"
                                :tabindex="5">
                                Forgot Password?
                            </TextLink>
                        </div>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            v-model="form.password"
                            placeholder="••••••••"
                            class="bg-gray-700 text-gray-200 border-gray-600 focus:border-orange-400
                                   focus:ring-2 focus:ring-orange-400/50 rounded-md py-3 px-4
                                   transition-all duration-300 hover:bg-gray-600"/>
                        <InputError :message="form.errors.password" class="text-orange-400 text-xs"/>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between" :tabindex="3">
                        <Label for="remember" class="flex items-center space-x-3 text-gray-200">
                            <Checkbox
                                id="remember"
                                v-model:checked="form.remember"
                                :tabindex="4"
                                class="border-gray-600 text-orange-400 focus:ring-orange-400/50
                                       rounded-sm transition-all duration-300"/>
                            <span class="font-medium">Remember Me</span>
                        </Label>
                    </div>

                    <!-- Submit Button -->
                    <Button
                        type="submit"
                        class="mt-4 w-full py-3 bg-orange-500 text-white font-semibold rounded-full
                               hover:bg-orange-600 transition-all duration-300 transform hover:scale-105
                               hover:shadow-lg hover:shadow-orange-500/50 flex items-center justify-center
                               disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="form.processing"
                        :tabindex="5">
                        <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin mr-2"/>
                        <span>Log In</span>
                    </Button>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center text-sm text-gray-400">
                    Don’t have an account?
                    <TextLink
                        :href="route('register')"
                        class="text-orange-400 hover:text-orange-500 underline underline-offset-4
                               transition-all duration-300 hover:scale-105"
                        :tabindex="6">
                        Sign Up
                    </TextLink>
                </div>
            </form>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="w-24 h-24 bg-orange-400 rounded-full filter blur-3xl opacity-10
                        absolute top-10 left-10 animate-float"></div>
            <div class="w-32 h-32 bg-orange-500 rounded-full filter blur-3xl opacity-10
                        absolute bottom-10 right-10 animate-float delay-1000"></div>
        </div>
    </AuthBase>
</template>

<style>
/* Custom Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.animate-fadeIn {
    animation: fadeIn 1s ease-out forwards;
}

.animate-slideUp {
    animation: slideUp 1s ease-out forwards;
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.delay-1000 {
    animation-delay: 1s;
}
</style>
