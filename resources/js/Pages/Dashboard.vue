<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { data } from 'autoprefixer';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'



const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});


// State
const showModal = ref(false)
const selectedUserId = ref(null)

// Open modal with selected user
function confirmDelete(id) {
  selectedUserId.value = id
  showModal.value = true
}


// Execute delete
function deleteUser() {
  router.delete(`/users/${selectedUserId.value}`, {
    onFinish: () => {
      showModal.value = false
      selectedUserId.value = null
    }
  })
}

// function deleteUser(id){
//     if (confirm('Are you sure you want to delete this user?')) {
//         router.delete(`/users/${id}`)
//     }
// }

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2  class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <!-- Flash Message -->
        <!-- <transition name="fade">
        <div
            v-if="$page.props.flash.success"
            class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded shadow"
        >
            {{ $page.props.flash.success }}
        </div>
        </transition> -->

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

                        <!-- Flash Message -->
                        <transition name="fade">
                            <div
                                v-if="$page.props.flash.success"
                                class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded shadow"
                            >
                                {{ $page.props.flash.success }}
                            </div>
                        </transition>
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
                                    @click="confirmDelete(user.id)"
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

        <!-- Confirmation Modal -->
        <transition name="fade">
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
                <h3 class="text-lg font-semibold mb-4">Confirm Deletion</h3>
                <p class="mb-6 text-gray-700">Are you sure you want to delete this user?</p>
                <div class="flex justify-end gap-3">
                <button
                    @click="showModal = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                >
                    Cancel
                </button>
                <button
                    @click="deleteUser"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                >
                    Confirm
                </button>
                </div>
            </div>
            </div>
        </transition>

    </AppLayout>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* .fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
 */

</style>
