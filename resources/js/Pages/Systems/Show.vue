<template>
    <default-page :title="ucwords(system.info.name) + ' Detail'"
                  content="Update System users and tags below."
    >

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="submitForm">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">System Name</label>
                                <input type="text" name="name" id="name" v-model="builder.name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                <input-error class="mt-2" :message="errors.name"></input-error>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="repository_url" class="block text-sm font-medium text-gray-700">Repository URL</label>
                                <input type="url" name="repository_url" id="repository_url" v-model="builder.repository_url"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                <input-error class="mt-2" :message="errors.repository_url"></input-error>
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" v-model="builder.description"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Select Users</label>
                                <div class="mt-4 space-y-4">

                                    <div class="flex items-start" v-for="user in users" :key="user.id">
                                        <div class="flex items-center h-5">
                                            <input :id="'user-' + user.id" :value="user.id" name="users[]"
                                                   v-model="builder.users" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label :for="'user-' + user.id" class="font-medium text-gray-700">
                                                {{ ucwords(user.name) }}
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <input-error class="mt-2" :message="errors.users"></input-error>
                            </div>


                            <div class="col-span-6 sm:col-span-3 ">
                                <label class="block text-sm font-medium text-gray-700">Select Tags</label>
                                <div class="mt-4 grid grid-cols-6  ">

                                    <div class="lg:col-span-2 sm:col-span-3 flex" v-for="tag in tags" :key="tag.id">
                                        <div class="flex items-center h-5">
                                            <input :id="'tag-' + tag.id" v-model="builder.tags" :value="tag.id"
                                                   name="tags[]" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                        </div>
                                        <div class="ml-1 text-sm">
                                            <label :for="'tag-' + tag.id" class="font-medium text-gray-700">
                                                {{ tag.name }}
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <input-error class="mt-2" :message="errors.tags"></input-error>
                            </div>

                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 sm:px-6 grid grid-cols-6">

                        <div class="col-span-3 sm:col-span-3 text-left">
                            <p class="text-lg font-weight-bold">
                                <strong>API Key: </strong>
                                {{ system.info.system_api_key }}
                            </p>
                        </div>

                        <div class="col-span-3 sm:col-span-3 text-right">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update System
                            </button>
                        </div>

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
    props: ['users', 'tags', 'system'],
    name: "Create",
    components: {
        InputError,
        StatusModal,
        DefaultPage
    },
    data() {
        return {
            builder: {
                name: this.system.info.name,
                repository_url: this.system.info.repository_link,
                description: this.system.info.description,
                users: this.system.users,
                tags: this.system.tags
            },
            errors: {
                name: '',
                repository_url: '',
                users: '',
                tags: ''
            },
            showStatus: false,
            statusType: 'loading',
            statusTitle: '',
            statusContent: '',
        }
    },
    methods: {
        submitForm() {

            if (!this.validateForm())
                return;

            this.statusTitle = 'Updating System';
            this.statusContent = 'Hold on while we update system...';
            this.showStatus = true;

            //
            axios.put(route('systems.update', this.system.info.id), this.builder)
                .then(({status, data}) => {
                    // handle success
                    if (status === 200){
                        //check if response code is 0
                        if (data.code === 0){
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
            this.statusTitle = 'System Updated Successfully.';
            this.statusContent = 'The system has been updated successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'System not Updated.';
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
                    this.$inertia.visit(route('systems.index'))
                }


            }, 2000);
        },

        validateForm() {
            let ok = true;

            this.errors.name = '';
            this.errors.repository_url = '';
            this.errors.users = '';
            this.errors.tags = '';

            if (this.builder.name === '') {
                this.errors.name = 'Full name is required.'
                ok = false;
            }
            if (this.builder.repository_url === '') {
                this.errors.repository_url = 'Email Address is required.'
                ok = false;
            }
            if (this.builder.users.length === 0) {
                this.errors.users = 'Select at least one user.'
                ok = false;
            }
            if (this.builder.tags.length === 0) {
                this.errors.tags = 'Select at least one tag.'
                ok = false;
            }

            return ok;

        }
    }
}
</script>

<style scoped>

</style>
