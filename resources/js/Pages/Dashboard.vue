<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { data } from 'autoprefixer';
import { router } from '@inertiajs/vue3'



const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

function deleteUser(id){
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(`/users/${id}`)
    }
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2  class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <ApplicationLogo class="block h-12 w-auto" />

                            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                                Welcome to your Jetstream application!
                            </h1>


                        </div>

                        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">

                            <div
                            v-for="user in props.users"
                            :key="user.id"
                            class="p-4 bg-white rounded-lg shadow"
                            >
                                <div>
                                    <p class="text-lg font-medium text-gray-900">
                                        👤 {{ user.name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Email: {{ user.email }}
                                    </p>
                                </div>

                                <button
                                    @click="deleteUser(user.id)"
                                    class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"
                                >
                                    Delete
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
