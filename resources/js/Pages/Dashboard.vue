<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { data } from 'autoprefixer';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';



const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});


// State
const showModalDelete = ref(false)
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

// Create User
const form = ref({
    name: '',
    email: '',
    password: '',
    errors: {
        name: null,
        email: null,
        password: null,
    },
});
const showModal = ref(false);
const openModal = () => {
    showModal.value = true;
};


const submit = () => {
    form.value.errors.name = null;
    form.value.errors.email = null;
    form.value.errors.password = null;

    router.post('/store', form.value, {
        onFinish: () => {
            showModal.value = false;
            form.value.name = '';
            form.value.email = '';
            form.value.password = '';
        },
        onError: (errors) => {
            if (errors.name) {
                form.value.errors.name = errors.name[0];
            }
            if (errors.email) {
                form.value.errors.email = errors.email[0];
            }
            if (errors.password) {
                form.value.errors.password = errors.password[0];
            }
        },
    });
};


// Edit User
const showModalEdit = ref(false);
const editngUserId = ref(null);
const openEditModal = (id) => {
    showModalEdit.value = true;
    editngUserId.value = id;
    const user = props.users.find(user => user.id === id);
    form.value.name = user.name;
    form.value.email = user.email;
    form.value.password = '';
};
const submitEdit = () => {
    form.value.errors.name = null;
    form.value.errors.email = null;

    router.put(`/update/${editngUserId.value}`, form.value, {
        onFinish: () => {
            showModalEdit.value = false;
            form.value.name = '';
            form.value.email = '';
            editngUserId.value = null;
        },
        onError: (errors) => {
            if (errors.name) {
                form.value.errors.name = errors.name[0];
            }
            if (errors.email) {
                form.value.errors.email = errors.email[0];
            }
        },
    });
};

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
                                Welcome to your User management!
                            </h1>


                        </div>

                        <!-- Button -->
                        <div class="mb-4">
                            <button
                                @click="openModal"
                                class="bg-blue-600 text-white px-4 py-2 mt m-4 rounded hover:bg-blue-700"
                            >
                                Create User
                            </button>
                        </div>

                        <!-- Create Modal -->
                        <transition name="fade">
                            <div
                                v-if="showModal"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                            >
                                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                                <h3 class="text-lg font-semibold mb-4">Create New User</h3>

                                <form @submit.prevent="submit" class="space-y-4">
                                    <div>
                                    <label class="block text-sm">Name</label>
                                    <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                                    </div>

                                    <div>
                                    <label class="block text-sm">Email</label>
                                    <input v-model="form.email" type="email" class="w-full border p-2 rounded" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</span>
                                    </div>

                                    <div>
                                    <label class="block text-sm">Password</label>
                                    <input v-model="form.password" type="password" class="w-full border p-2 rounded" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</span>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        @click="showModal = false"
                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                    >
                                        Create
                                    </button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </transition>

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

                                <div class="mt-1">
                                    <button @click="openEditModal(user.id)" class="bg-orange-600 mr-2 text-white px-4 py-1 rounded hover:bg-red-700">Edit</button>
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
        </div>

        <!-- Edit Modal -->
        <transition name="fade">
            <div
            v-if="showModalEdit"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            >
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">Edit User</h3>

                <form @submit.prevent="submitEdit" class="space-y-4">
                <div>
                    <label class="block text-sm">Name</label>
                    <input v-model="form.name" type="text" class="w-full border p-2 rounded" />
                    <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                </div>

                <div>
                    <label class="block text-sm">Email</label>
                    <input v-model="form.email" type="email" class="w-full border p-2 rounded" />
                    <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                </div>

                <div class="flex justify-end gap-2">
                    <button @click="showModalEdit = false" type="button" class="px-4 py-2 bg-gray-300 rounded">
                    Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
                    Save Changes
                    </button>
                </div>
                </form>
            </div>
            </div>
        </transition>

        <!-- Delete Confirmation Modal -->
        <transition name="fade">
            <div v-if="showModalDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
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
