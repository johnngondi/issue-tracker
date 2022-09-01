<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <default-index title="User"
                                   description="Manage all Users from here."
                                   :add-button="canCreate"
                                   :add-button-url="route('users.create')"
                    >

                        <div class="block">

                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div
                                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg pb-24 bg-white">
                                        <table class="min-w-full divide-y divide-gray-200 border-b border-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Roles
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tags
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Joined
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="user in users" :key="user.email">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full"
                                                                 :src="user.profile_photo_url" alt=""/>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ user.name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ user.email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div v-for="role in user.roles" class="text-sm text-gray-500">
                                                        {{ this.ucwords(role.name) }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                      <span v-for="tag in user.tags" :key="tag.id"
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                        {{ tag.name }}
                                                      </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ new Date(user.created_at).toDateString() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <jet-dropdown align="right" width="48">
                                                        <template #trigger>
                                                            <button
                                                                class="border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                     fill="none" viewBox="0 0 24 24"
                                                                     stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          stroke-width="2"
                                                                          d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                                </svg>
                                                            </button>

                                                        </template>

                                                        <template #content>
                                                            <!-- Account Management -->
                                                            <jet-dropdown-link :href="route('users.show', user.id)"
                                                                               v-if="canCreate">
                                                                    <span class="">
                                                                        View User
                                                                    </span>

                                                            </jet-dropdown-link>

                                                            <div class="border-t border-gray-100"
                                                                 v-if="canCreate"></div>

                                                            <jet-dropdown-link as="button" type="button"
                                                                               @click="deleteResource(user.id)"
                                                                               v-if="canCreate">
                                                                    <span class="text-red-600 ">
                                                                        Delete User
                                                                    </span>

                                                            </jet-dropdown-link>

                                                        </template>
                                                    </jet-dropdown>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </default-index>

                </div>
            </div>
        </div>

        <jet-confirmation-modal :show="confirmDelete" @close="closeModal">

            <template #title>
                Confirm Delete.
            </template>

            <template #content>
                Are you sure you want to delete this User?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deleteUser">
                    Delete User
                </jet-danger-button>
            </template>

        </jet-confirmation-modal>

        <status-modal :show="showStatus" :type="statusType">
            <template #title>
                {{ statusTitle }}
            </template>

            <template #content>
                {{ statusContent }}
            </template>

        </status-modal>

    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import DefaultIndex from '@/components/interface/DefaultIndex';
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import StatusModal from "@/Jetstream/StatusModal";


export default {
    props: ['users', 'canCreate'],
    components: {
        StatusModal,
        AppLayout,
        DefaultIndex,
        JetDropdown,
        JetDropdownLink,
        JetConfirmationModal,
        JetDangerButton,
        JetSecondaryButton
    },
    data() {
        return {
            confirmDelete: false,
            deleteResourceId: '',

            showStatus: false,
            statusType: 'loading',
            statusTitle: '',
            statusContent: '',

        }
    },
    mounted() {
        document.title = 'Users - ' + this.$page.props.appName;
    },
    methods: {
        deleteResource(id) {
            this.confirmDelete = true;
            this.deleteResourceId = id;
        },

        deleteUser() {
            this.confirmDelete = false;

            this.statusTitle = 'Deleting User!';
            this.statusContent = 'Hold on a moment...';
            this.showStatus = true;

            //send axios request
            axios.delete(route('users.destroy', this.deleteResourceId))
                .then(({status, data}) => {
                    // handle success
                    if (status === 200){
                        //check if response code is 0
                        if (data.code === 0){
                            this.showSuccessStatusModal()
                        } else {
                            this.showErrorStatusModal()
                        }
                    } else {
                        this.showErrorStatusModal()
                    }
                })
                .catch((error) => {
                    // handle error
                    this.showErrorStatusModal()
                })
        },

        closeModal() {
            this.confirmDelete = false
            this.deleteResourceId = '';
        },

        showSuccessStatusModal() {
            this.statusType = 'success';
            this.statusTitle = 'User Deleted.';
            this.statusContent = 'The user has been deleted successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'User not Deleted.';
            this.statusContent = 'Something happened, please contact admin!';
            this.showStatus = true;

            this.closeStatusModal();
        },

        closeStatusModal(redirect = false) {
            setTimeout(() => {
                this.statusType = 'loading';
                this.statusTitle = '';
                this.statusContent = '';
                this.showStatus = false;

                if (redirect) {
                    this.$inertia.reload()
                }

            }, 2000);
        }
    }

}
</script>
