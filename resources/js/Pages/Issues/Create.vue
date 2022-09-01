<template>
    <default-page title="Add New Issue"
                  content="Fill in the form Below to create new Issue."
    >

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="submitForm">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6">
                                <h5>Issue Information</h5>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700">Issue Title</label>
                                <input type="text" name="title" id="title" v-model="builder.title"
                                       required
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
<!--                                <input-error class="mt-2" :message="errors.title"></input-error>-->
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="system_id" class="block text-sm font-medium text-gray-700">Software System</label>
                                <select name="system_id" id="system_id" v-model="builder.system_id"
                                        required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected disabled>
                                        - Select System -
                                    </option>

                                    <option v-for="system in systems" :key="system.info.id" :value="system.info.id">
                                        {{ ucwords(system.info.name) }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="type" class="block text-sm font-medium text-gray-700">Issue Type</label>
                                <select name="type" id="type" v-model="builder.type"
                                        required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected disabled>
                                        - Select Issue Type -
                                    </option>
                                    <option value="bug">Bug</option>
                                    <option value="feature">Feature</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="urgency" class="block text-sm font-medium text-gray-700">How Urgent</label>
                                <select name="urgency" id="urgency" v-model="builder.urgency"
                                        required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected disabled>
                                        - Select Urgency -
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="importance" class="block text-sm font-medium text-gray-700">How Important</label>
                                <select name="importance" id="importance" v-model="builder.importance"
                                        required
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="" selected disabled>
                                        - Select Importance -
                                    </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" v-model="builder.description"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                            </div>

<!--                            Requester Information -->
                            <div class="col-span-6 mt-3">
                                <h5>Requester Information</h5>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="requester_name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="requester_name" id="requester_name" v-model="builder.requester_name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required/>
<!--                                <input-error class="mt-2" :message="errors.requester_name"></input-error>-->
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="requester_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="text" name="requester_email" id="requester_email" v-model="builder.requester_email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required/>
<!--                                <input-error class="mt-2" :message="errors.requester_email"></input-error>-->
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="requester_dept" class="block text-sm font-medium text-gray-700">Department</label>
                                <input type="text" name="requester_dept" id="requester_dept" v-model="builder.requester_dept"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
<!--                                <input-error class="mt-2" :message="errors.requester_dept"></input-error>-->
                            </div>



                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Issue
                        </button>
                    </div>
                </div>
            </form>
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
    props: ['systems'],
    name: "CreateIssue",
    components: {
        InputError,
        StatusModal,
        DefaultPage
    },
    data() {
        return {
            builder: {
                title: '',
                system_id: '',
                urgency: '',
                importance: '',
                type: '',
                description: '',
                requester_name: '',
                requester_email: '',
                requester_dept: ''
            },
            showStatus: false,
            statusType: 'loading',
            statusTitle: '',
            statusContent: '',
            newIssue: null
        }
    },
    methods: {
        submitForm() {

            if (!this.validateForm())
                return;

            this.statusTitle = 'Adding Issue';
            this.statusContent = 'Hold on while we add issue...';
            this.showStatus = true;

            //
            axios.post(route('issues.store'), this.builder)
                .then(({status, data}) => {
                    // handle success
                    if (status === 200){
                        //check if response code is 0
                        if (data.code === 0){
                            this.newIssue = data.issue;
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
            this.statusTitle = 'Issue Added Successfully.';
            this.statusContent = 'The issue has been deleted successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'Issue not Added.';
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

                if (redirect){
                    this.$inertia.visit(route('issues.show', this.newIssue.id))
                }

            }, 2000);
        },

        validateForm() {
            return true;
        }
    }
}
</script>

<style scoped>

</style>
