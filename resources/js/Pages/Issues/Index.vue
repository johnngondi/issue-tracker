<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <default-index title="Issue"
                                   description="Manage all Issues from here."
                                   :add-button="canCreate"
                                   :add-button-url="route('issues.create')"
                    >

                        <div class="block">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div
                                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg pb-16 bg-white">

                                        <form @submit.prevent="filterIssues">
                                            <div class="py-5 grid grid-cols-6 ml-4 content-center">
                                                <div class="lg:col-span-1 sm:col-span-1 flex mt-3">
                                                    <div class="flex items-center h-5">
                                                        <input id="completed" v-model="filter.completed"
                                                               name="completed" type="checkbox"
                                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                                    </div>
                                                    <div class="ml-1 text-sm">
                                                        <label for="completed" class="font-medium text-gray-700">
                                                            Show Completed
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="lg:col-span-1 sm:col-span-1 flex mt-3">
                                                    <div class="flex items-center h-5">
                                                        <input id="rejected" v-model="filter.rejected"
                                                               name="rejected" type="checkbox"
                                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                                    </div>
                                                    <div class="ml-1 text-sm">
                                                        <label for="rejected" class="font-medium text-gray-700">
                                                            Show Rejected
                                                        </label>
                                                    </div>
                                                </div>


                                                <div class="lg:col-span-1 sm:col-span-1 flex">
                                                    <button type="submit"
                                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Show Filtered
                                                    </button>
                                                </div>


                                            </div>

                                            <div class="lg:col-span-6 sm:col-span-6 flex border-b">
                                            </div>

                                        </form>

                                        <table v-if="allIssues.length > 0" class="min-w-full divide-y divide-gray-200 border-b border-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                    Title
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                    Assigned To
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                    Raised By
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                    Duration
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                                    Time Stamps
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">

                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 ">
                                            <tr v-for="issue in allIssues" :key="issue.id"
                                                :class="(issue.status === 5) ? 'bg-green-100' : ((issue.status === 3) ? 'bg-purple-100' : ((issue.status === 6) ? 'bg-gray-100 line-through' : ((issue.type === 'bug') ? 'bg-red-100' : 'bg-gray-white')))">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">
                                                        <h5>{{ this.ucwords(issue.title) }} </h5>
                                                        <p class="text-sm text-gray-400 truncate">
                                                            on
                                                            <a target="_blank" title="Open project repository" class="text-indigo-600" :href="issue.repository_link">
                                                                {{ this.ucwords(issue.system_name) }}
                                                            </a>

                                                        </p>

                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap ">

                                                    <template v-if="issue.status === 0">
                                                        <span class="text-red-500">
                                                            Un Assigned
                                                        </span>
                                                    </template>

                                                    <template v-else-if="issue.status === 6">
                                                        N/A
                                                    </template>

                                                    <template v-else>
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full"
                                                                     :src="(issue.profile_photo_path !== null) ? issue.profile_photo_path : 'https://ui-avatars.com/api/?name=' + issue.user_name + '&color=7F9CF5&background=EBF4FF' " alt=""/>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ this.ucwords(issue.user_name) }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ issue.email }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>

                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    Name:
                                                    {{ this.ucwords(issue.requester_name) }}
                                                    <br>
                                                    Email:
                                                    {{ issue.requester_email }}
                                                    <br>
                                                    Dept:
                                                    {{ this.ucwords(issue.requester_dept) }}

                                                    <template v-if="issue.type === 'bug'">
                                                        <br>
                                                        <b>Page</b>:
                                                        <a target="_blank" class="text-indigo-600" :href="issue.page_url">
                                                            {{ ucfirst(issue.page_title) }}
                                                        </a>
                                                    </template>

                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                                                    <template v-if="issue.status === 0">
                                                        <span class="text-red-500">
                                                            Un Assigned
                                                        </span>
                                                    </template>

                                                    <template v-else-if="issue.status === 1">
                                                        <span class="text-pink-600">
                                                            Assigned - Pending
                                                        </span>
                                                    </template>

                                                    <template v-else-if="issue.status === 3">
                                                        <span class="text-indigo-500">
                                                            Assigned - Started
                                                        </span>
                                                    </template>

                                                    <template v-else-if="issue.status === 4">
                                                        <span class="text-pink-600">
                                                            Assigned - Paused
                                                        </span>
                                                    </template>

                                                    <template v-else-if="issue.status === 5">
                                                        <span class="text-green-800">
                                                            Completed
                                                        </span>
                                                    </template>

                                                    <template v-else-if="issue.status === 6">
                                                        <span class="text-gray-500">
                                                            Rejected
                                                        </span>
                                                    </template>

                                                </td>


                                                <td class="px-6 py-4 text-sm text-gray-500">

                                                    <template v-if="issue.status !== 0  && issue.status !== 6">
                                                        <template v-if="issue.started_at !== null">
                                                            Start Date:
                                                            {{ new Date(issue.started_at).toDateString() }}
                                                            <br>
                                                        </template>

                                                        <template v-else>
                                                            Planned Start Date:
                                                            {{ new Date(issue.planned_start_at).toDateString() }}
                                                            <br>
                                                        </template>

                                                        Duration Assigned: {{ issue.days }} days.
                                                        <br>

                                                        <template v-if="issue.completed_at !== null">
                                                            Date Ended:
                                                            {{ new Date(issue.completed_at).toDateString() }}
                                                        </template>
                                                    </template>

                                                    <template v-else>
                                                        N/A
                                                    </template>

                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    Added On:
                                                    {{ new Date(issue.created_at).toDateString() }}
                                                    <br>
                                                    Updated On:
                                                    {{ new Date(issue.updated_at).toDateString() }}
                                                </td>

                                                <td class="px-6 text-sm font-medium">
                                                    <div class="relative">
                                                        <jet-dropdown align="right" width="48">
                                                            <template #trigger>
                                                                <button
                                                                    class="border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                                         stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                              stroke-linejoin="round" stroke-width="2"
                                                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                                                    </svg>
                                                                </button>

                                                            </template>

                                                            <template #content>
                                                                <!-- Account Management -->
                                                                <jet-dropdown-link
                                                                    :href="route('issues.show', issue.id)"
                                                                >
                                                                    <span class="">
                                                                        View Issue
                                                                    </span>

                                                                </jet-dropdown-link>

                                                                <div class="border-t border-gray-100"
                                                                     v-if="canDelete && issue.status === 0"></div>

                                                                <jet-dropdown-link as="button"
                                                                                   type="button"
                                                                                   @click="deleteResource(issue.id)"
                                                                                   v-if="canDelete && issue.status === 0"
                                                                >
                                                                    <span class="text-red-600 ">
                                                                        Delete Issue
                                                                    </span>

                                                                </jet-dropdown-link>

                                                            </template>
                                                        </jet-dropdown>
                                                    </div>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <p v-else class="text-gray-500 text-center mt-6">
                                            No issues available under that criteria. User the filter above to see more.
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </default-index>

                </div>
            </div>
        </div>


        <jet-confirmation-modal v-if="canDelete" :show="confirmDelete" @close="closeModal">

            <template #title>
                Confirm Delete.
            </template>

            <template #content>
                Are you sure you want to delete this Issue?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deleteIssue">
                    Delete Issue
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
import JetDangerButton from '@/Jetstream/DangerButton';
import JetSecondaryButton from '@/Jetstream/SecondaryButton';

export default {
    props: ['issues', 'canCreate', 'canDelete'],
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
            allIssues: this.issues,

            confirmDelete: false,
            deleteResourceId: '',

            showStatus: false,
            statusType: 'loading',
            statusTitle: '',
            statusContent: '',

            filter: {
                completed: false,
                rejected: false,
            }
        }
    },
    mounted() {
        document.title = 'Software Issues - ' + this.$page.props.appName;
    },
    methods: {
        deleteResource(id) {
            this.confirmDelete = true;
            this.deleteResourceId = id;
        },

        deleteIssue() {
            this.confirmDelete = false;

            this.statusTitle = 'Deleting Issue!';
            this.statusContent = 'Hold on a moment...';
            this.showStatus = true;

            //send axios request
            axios.delete(route('issues.destroy', this.deleteResourceId))
                .then(({status, data}) => {
                    // handle success
                    if (status === 200) {
                        //check if response code is 0
                        if (data.code === 0) {
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
            this.statusTitle = 'Issue Deleted.';
            this.statusContent = 'The user has been deleted successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'Issue not Deleted.';
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
                    this.$inertia.visit(route('issues.index'))
                }

            }, 2000);
        },

        filterIssues() {
            this.statusTitle = 'Getting filtered issues!';
            this.statusContent = 'Hold on a moment...';
            this.statusType = 'loading';
            this.showStatus = true;

            //send axios request
            axios.get(route('issues.filter', this.filter))
                .then(({status, data}) => {
                    // handle success
                    if (status === 200) {

                        this.allIssues = data.issues;
                    }

                    this.showStatus = false;

                })
                .catch((error) => {
                    // handle error
                    this.showStatus = false;
                })
        }
    }

}
</script>
