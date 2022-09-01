<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                {{  title }}s
            </div>

            <div class="mt-6 text-gray-500">
                <p v-html="description"></p>


                <div class="mt-6" v-if="addButton">
                    <jet-button-link :href="addButtonUrl"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>

                        <span class="pl-1">
                            Add New {{ title }}
                        </span>
                    </jet-button-link>
                </div>
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 block">
            <div class="p-6">
                <div class="ml-3 mr-3">
                    <div class="mt-2 text-sm text-gray-500 ">

                        <slot></slot>

                    </div>
                </div>

            </div>

        </div>
    </div>
</template>


<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo';
    import JetButtonLink from "@/Jetstream/ButtonLink";

    export default {
        props : {
            title: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: true
            },
            addButton: {
                type: Boolean,
                default: false,
            },
            addButtonUrl: {
                type: String,
                default: '#',
            },
        },
        components: {
            JetApplicationLogo,
            JetButtonLink
        },
        methods: {
            addModal(){
                console.log('showing modal')
            }
        }
    }
</script>
