<template>
    <div>
        <button :type="type" class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" v-if="as == 'button'">
            <slot></slot>
        </button>

        <a :href="href" target="_blank" class="block px-4 py-2 text-sm leading-5  text-left text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" v-else-if="as =='a'">
            <slot></slot>
        </a>

        <inertia-link :href="href" class="block px-4 py-2 text-sm leading-5 text-left text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: {
            href: {
                type: String
            },
            as: {
                type:String
            },
            type: {
                type: String,
                default: 'submit'
            },
        }
    }
</script>
