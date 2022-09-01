<template>
    <default-page title="Add New User"
                  content="Fill in the form Below to create new User."
    >

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="submitForm">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="name" id="name" v-model="builder.name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                <input-error class="mt-2" :message="errors.name"></input-error>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="text" name="email" id="email" v-model="builder.email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                <input-error class="mt-2" :message="errors.email"></input-error>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Select Roles</label>
                                <div class="mt-4 space-y-4">

                                    <div class="flex items-start" v-for="role in roles" :key="role.id">
                                        <div class="flex items-center h-5">
                                            <input :id="'role-' + role.id" :value="role.id" name="roles[]"
                                                   v-model="builder.roles" type="checkbox"
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label :for="'role-' + role.id" class="font-medium text-gray-700">
                                                {{ ucwords(role.name) }}
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <input-error class="mt-2" :message="errors.roles"></input-error>
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
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add User
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
    props: ['roles', 'tags'],
    name: "Create",
    components: {
        InputError,
        StatusModal,
        DefaultPage
    },
    data() {
        return {
            builder: {
                name: '',
                email: '',
                roles: [],
                tags: []
            },
            errors: {
                name: '',
                email: '',
                roles: '',
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

            this.statusTitle = 'Adding User';
            this.statusContent = 'Hold on while we add user.';
            this.showStatus = true;

            //
            axios.post(route('users.store'), this.builder)
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
            this.statusTitle = 'User Added Successfully.';
            this.statusContent = 'The user has been created successfully!';
            this.showStatus = true;

            this.closeStatusModal(true);
        },

        showErrorStatusModal() {
            this.statusType = 'error';
            this.statusTitle = 'User not Added.';
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
                    this.$inertia.visit(route('users.index'))
                }


            }, 2000);
        },

        validateForm() {
            let ok = true;

            this.errors.name = '';
            this.errors.email = '';
            this.errors.roles = '';
            this.errors.tags = '';

            if (this.builder.name === '') {
                this.errors.name = 'Full name is required.'
                ok = false;
            }
            if (this.builder.email === '') {
                this.errors.email = 'Email Address is required.'
                ok = false;
            }
            if (this.builder.roles.length === 0) {
                this.errors.roles = 'Select at least one role.'
                ok = false;
            }
            // if (this.builder.tags.length === 0) {
            //     this.errors.tags = 'Select at least one tag.'
            //     ok = false;
            // }

            return ok;

        }
    }
}
</script>

<style scoped>

</style>
