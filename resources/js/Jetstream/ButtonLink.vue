<template>
    <a :href="href"
       v-if="type === 'a'"
       class="inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition"
    >

        <slot></slot>
    </a>

    <inertia-link :href="href"
                  v-else
                  class="inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition"
    >

        <slot></slot>
    </inertia-link>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
        },
        href: {
            type: String,
            required: true
        }
    },

}
</script>
