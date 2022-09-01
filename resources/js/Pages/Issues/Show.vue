<template>
    <default-page :title="ucwords(issue.title) + ' Detail'"
                  :content="ucfirst(issue.description) + '.<br> ' +
                   ' <b>Created</b>: ' + new Date(issue.created_at).toDateString() +
                    ' | <b>Last Updated</b>: ' + new Date(issue.updated_at).toDateString() "
    >

        <div class="mt-5 md:mt-0 md:col-span-2">

            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6 sm:col-span-2">
                            <h4 class="font-bold">Issue Type</h4>
                            <p>{{ ucwords(issue.type) }}</p>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <h4 class="font-bold">Issue Status</h4>
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
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <h4 class="font-bold">Assigned To</h4>

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
                                             :src="issue.user.profile_photo_url" alt=""/>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ ucwords(issue.user.name) }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ issue.user.email }}
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <h4 class="font-bold">Software System</h4>
                            <p>
                                {{ ucwords(issueSystem.name) }}
                                <template v-if="issue.type === 'bug'">
                                    <br>
                                    <b>Page</b>:
                                    <a target="_blank" class="text-indigo-600" :href="issue.page_url">
                                        {{ issue.page_title }}
                                    </a>
                                </template>

                            </p>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <h4 class="font-bold">Requested By</h4>
                            <p>
                                {{ ucwords(issue.requester_name) }}
                                <br>
                                {{ issue.requester_email }}
                                <br>
                                {{ ucwords(issue.requester_dept) }}

                            </p>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <h4 class="font-bold">Duration</h4>
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
                        </div>

                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6">
                    <template v-if="issue.status === 0 && canAssign">

                        <form @submit.prevent="assignIssue" v-if="issue.status === 0" class="grid grid-cols-6 gap-6" method="post">
                            <div class="col-span-6">
                                <h4 class="font-bold">Assign Issue to Developer</h4>
                            </div>
                            <div class="col-span-2">
                                <label for="issue_developer">Developer</label>
                                <select name="issue_developer" id="issue_developer" v-model="assign.user"
                                        required
                                        class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected disabled>
                                        - Select Developer -
                                    </option>

                                    <option v-for="developer in developers" :value="developer.id">
                                        {{
                                            ucwords(developer.name)
                                        }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label for="planned_start">Planned Start</label>
                                <input type="date" name="planned_start" id="planned_start" v-model="assign.planned_start"
                                        required
                                        class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>

                            </div>

                            <div class="col-span-2">
                                <label for="days">Duration (Days)</label>
                                <input type="number" name="days" id="days" v-model="assign.days"
                                       required
                                       class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>

                            </div>
                            <div class="col-span-2">
                                <button type="submit"
                                        class=" justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Assign Issue
                                </button>
                            </div>

                        </form>

                        <hr class="mt-8">

                    </template>

                    <template v-if="(issue.status === 1 || issue.status === 3 || issue.status === 4) && canUpdate">

                        <form @submit.prevent="updateIssue" v-if="issue.status !== 6"
                              class="grid grid-cols-6 gap-6"
                              method="post">
                            <div class="col-span-6">
                                <h4 class="font-bold">Update Issue Status.</h4>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="importance" class="block text-sm font-medium text-gray-700">Action</label>
                                <select name="importance" id="importance" v-model="builder.status"
                                        required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected disabled>
                                        - Select Status -
                                    </option>
                                    <option v-for="status in statuses" :value="status.value">
                                        {{ status.text }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-span-3">
                                <label for="message">Reason for Status Change</label>
                                <textarea name="message" id="message" v-model="builder.message"
                                       required
                                       class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                            </div>

                            <div class="col-span-6">
                                <button type="submit"
                                        class=" justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Issue Status
                                </button>
                            </div>
                        </form>

                    </template>


                    <template v-if="issue.status !== 6 && issue.status !== 5 && canAssign">

                        <form @submit.prevent="rejectIssue" v-if="issue.status !== 6"
                              class="grid grid-cols-6 gap-6 mt-10"
                              method="post">
                            <div class="col-span-6">
                                <h4 class="font-bold">Reject Issue.</h4>
                            </div>

                            <div class="col-span-3">
                                <label for="update_message">Reason</label>
                                <textarea name="update_message" id="update_message" v-model="reject.message"
                                          required
                                          class=" focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>

                            </div>

                            <div class="col-span-6">
                                <button type="submit"
                                        class=" justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Reject Issue
                                </button>
                            </div>
                        </form>

                    </template>

                </div>
            </div>

                <div class="px-4 bg-white sm:p-6 mt-6 sm:rounded-lg">

                    <h4 class=" text-md mb-2 ml-1">Issue Logs</h4>

                    <div
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">

                        <table class="min-w-full divide-y divide-gray-200 border-b border-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Action
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Details
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                    Timestamp
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="log in issue.logs" :key="log.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ ucwords(log.action) }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ ucfirst(log.message) }}
                                </td>

                                <td class="px-6 py-4 ">
                                    {{ new Date(log.created_at).toDateString() }}
                                    at
                                    {{ new Date(log.created_at).toLocaleTimeString() }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
            </div>

        </div>

        <status-modal :show="showStatus" :type="statusType">
            <template #title>
                {{ statusTitle }}
            </template>

            <template #content>
                {{ statusContent }}
            </template>

        </status-modal>


    </default-page>

</template>

<script>
import DefaultPage from "@/components/interface/DefaultPage";
import StatusModal from "@/Jetstream/StatusModal";
import InputError from "@/Jetstream/InputError";

export default {
    props: ['canUpdate', 'canAssign', 'developers', 'issue', 'issueSystem'],
    name: "IssueInfo",
    components: {
        InputError,
        StatusModal,
        DefaultPage
    },
    data() {
        return {
            builder: {
                status: '',
                message: ''
            },
            assign: {
                user: '',
                planned_start: null,
                days: 4
            },
            reject:{
                message: ''
            },
            showStatus: false,
            statusType: 'loading',
            statusTitle: '',
            statusContent: '',
        }
    },

    computed: {

        statuses (){
            let statuses = [];
            if (this.issue.status === 1 || this.issue.status === 4){
                statuses.push({
                    value: 3,
                    text: 'Start'
                });
            }

            if (this.issue.status === 3){
                statuses.push({
                    value: 4,
                    text: 'Pause'
                },{
                    value: 5,
                    text: 'Complete'
                });
            }

            return statuses;
        }

    },

    methods: {

        assignIssue() {
            this.statusTitle = 'Assigning Issue';
            this.statusContent = 'Hold on while we assign issue...';
            this.showStatus = true;

            //
            axios.put(route('issues.assign', this.issue.id), this.assign)
                .then(({status, data}) => {
                    // handle success
                    if (status === 200) {
                        //check if response code is 0
                        if (data.code === 0) {
                            this.showSuccessStatusModal()
                        } else {
                            console.log(data)
                            this.showErrorStatusModal()
                        }
                    } else {
                        this.showErrorStatusModal()
                    }
                })
                .catch((error) => {
                    console.log(error)
                    // handle error
                    this.showErrorStatusModal()
                })
        },

        updateIssue() {
            this.statusTitle = 'Updating Issue Status';
            this.statusContent = 'Hold on while we update issue status...';
            this.showStatus = true;

            axios.put(route('issues.update', this.issue.id), this.builder)
                .then(({status, data}) => {
                    // handle success
                    if (status === 200) {
                        //check if response code is 0
                        if (data.code === 0) {
                            this.showSuccessStatusModal()
                        } else {
                            console.log(data)
                            this.showErrorStatusModal()
                        }
                    } else {
                        this.showErrorStatusModal()
                    }
                })
                .catch((error) => {
                    console.log(error)
                    // handle error
                    this.showErrorStatusModal()
                })
        },

        rejectIssue() {
            this.statusTitle = 'Rejecting Issue';
            this.statusContent = 'Hold on while we reject issue status...';
            this.showStatus = true;

            axios.put(route('issues.reject', this.issue.id), this.reject)
                .then(({status, data}) => {
                    // handle success
                    if (status === 200) {
                        //check if response code is 0
                        if (data.code === 0) {
                            this.showSuccessStatusModal()
                        } else {
                            console.log(data)
                            this.showErrorStatusModal()
                        }
                    } else {
                        this.showErrorStatusModal()
                    }
                })
                .catch((error) => {
                    console.log(error)
                    // handle error
                    this.showErrorStatusModal()
                })
        },

        showSuccessStatusModal() {
            this.statusType = 'success';
            this.statusTitle = 'Issue Updated Successfully.';
            this.statusContent = 'The issue has been updated successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'Issue not Updated.';
            this.statusContent = 'Check your data & try again, please contact admin if this persists!';
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
                    this.$inertia.visit(route('issues.show', this.issue.id))
                }

            }, 2000);
        },

        validateForm() {
            // let ok = true;
            //
            // return ok;

        }
    }
}
</script>

<style scoped>

</style>
