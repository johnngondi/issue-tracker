<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <default-index title="Software System"
                                   description="Manage all Software Systems from here."
                                   :add-button="canCreate"
                                   :add-button-url="route('systems.create')"
                    >

                        <div class="block">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg pb-24 bg-white">
                                        <table class="min-w-full divide-y divide-gray-200 border-b border-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Users
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Tags
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Issues
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Time Stamps
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">

                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="system in systems" :key="system.id">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">
                                                        {{ this.ucwords(system.info.name) }} <br>
                                                        <p class="text-sm text-gray-300 truncate">
                                                            {{ this.ucfirst(system.info.description) }}
                                                        </p>

                                                        <span v-if="system.info.status == 1" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                            Active
                                                        </span>

                                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Inactive
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap">

                                                        <div class="flex -space-x-2 overflow-hidden">
                                                            <img v-for="user in system.users"
                                                                 :src="user.profile_photo_url"
                                                                 :alt="user.name"
                                                                 width="48" height="48"
                                                                 class="w-10 h-10 rounded-full bg-gray-100 border-2 border-white transform motion-safe:hover:scale-110" />
                                                        </div>

                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div v-for="tag in system.tags" :key="tag.id">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                            {{ tag }}
                                                        </span>
                                                    </div>

                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Done:
                                                    <span class="text-green-500">
                                                        {{ system.doneIssuesCount }}
                                                    </span>
                                                    <br>

                                                    Assigned:
                                                    <span class="text-indigo-500">
                                                        {{ system.assignedIssuesCount }}
                                                    </span>
                                                    <br>

                                                    Un Assigned:
                                                    <span class="text-red-500">
                                                        {{ system.unAssignedIssuesCount }}
                                                    </span>
                                                    <br>

                                                    Rejected:
                                                    <span class="text-gray-500">
                                                        {{ system.rejectedIssuesCount }}
                                                    </span>
                                                    <br>

                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Added On:
                                                    {{ new Date(system.info.created_at).toDateString() }}
                                                    <br>
                                                    Updated On:
                                                    {{ new Date(system.info.updated_at).toDateString() }}
                                                </td>

                                                <td class="px-6 text-sm font-medium">
                                                    <div class="relative">
                                                        <jet-dropdown align="right" width="48">
                                                            <template #trigger>
                                                                <button class="border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                                    </svg>
                                                                </button>

                                                            </template>

                                                            <template #content>
                                                                <!-- Account Management -->
                                                                <jet-dropdown-link :href="route('systems.show', system.info.slug)"
                                                                                   v-if="canCreate"
                                                                >
                                                                    <span class="">
                                                                        View System
                                                                    </span>

                                                                </jet-dropdown-link>

                                                                <jet-dropdown-link as="a"
                                                                                   v-if="system.info.repository_link !== ''"
                                                                                   :href="system.info.repository_link">
                                                                    <span class="flex">

                                                                        Open Repository

                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                                                          <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                                          <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                                                        </svg>
                                                                    </span>

                                                                </jet-dropdown-link>

                                                                <div class="border-t border-gray-100"
                                                                     v-if="canCreate"></div>

                                                                <jet-dropdown-link as="button"
                                                                                   type="button"
                                                                                   @click="deleteResource(system.info.id)"
                                                                                   v-if="canCreate"
                                                                >
                                                                    <span class="text-red-600 ">
                                                                        Delete System
                                                                    </span>

                                                                </jet-dropdown-link>

                                                            </template>
                                                        </jet-dropdown>
                                                    </div>

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
                Are you sure you want to delete this System?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deleteSystem">
                    Delete System
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
import AppLayout from '@/Layouts/AppLayout'
import DefaultIndex from '@/components/interface/DefaultIndex'
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import StatusModal from "@/Jetstream/StatusModal";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    props: ['systems', 'canCreate'],
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
        document.title = 'Software Systems - ' + this.$page.props.appName;
    },
    methods: {
        deleteResource(id) {
            this.confirmDelete = true;
            this.deleteResourceId = id;
        },

        deleteSystem() {
            this.confirmDelete = false;

            this.statusTitle = 'Deleting System!';
            this.statusContent = 'Hold on a moment...';
            this.showStatus = true;

            //send axios request
            axios.delete(route('systems.destroy', this.deleteResourceId))
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
            this.statusTitle = 'System Deleted.';
            this.statusContent = 'The user has been deleted successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'System not Deleted.';
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
