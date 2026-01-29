<script setup>
import AuthenticatedLayout from '@Shared/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from '../Components/DeleteUserForm.vue';
import UpdatePasswordForm from '../Components/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '../Components/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-white">
                Account Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
                <div
                    class="bg-slate-900/50 backdrop-blur-xl p-6 shadow-2xl border border-slate-800 sm:rounded-3xl sm:p-10">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                        class="max-w-xl" />
                </div>

                <div
                    class="bg-slate-900/50 backdrop-blur-xl p-6 shadow-2xl border border-slate-800 sm:rounded-3xl sm:p-10">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="bg-red-950/20 backdrop-blur-xl p-6 shadow-2xl border border-red-900/30 sm:rounded-3xl sm:p-10">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
