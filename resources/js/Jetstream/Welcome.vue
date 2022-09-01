<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome to the {{ $page.props.appName }}!
            </div>

            <div class="mt-6 text-gray-500">
                This tool helps us manage all the issues raised on all <b>NW Realite LTD</b> Software Systems
                and any other system developed by <b>Verus Africa</b>. It also provides a simple API to connect
                with all those systems for faster issues raising. See API Documentation
                <a href="#" target="_blank" class="text-purple-800">here</a>.
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                        <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        Assigned Issues.
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="container flex">
                            <div class="rounded-full h-14 w-14 flex items-center justify-center border-4 border-indigo-700 font-semibold text-indigo-500 text-xl">
                                {{ assignedIssuesCount }}
                            </div>
                            <div class="flex items-center justify-center ml-4">
                                of {{ incompleteIssuesCount }} pending Issues.
                            </div>
                        </div>
                    </div>
                    <inertia-link  :href="route('issues.index')">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                <div>Explore all Issues</div>
                                <div class="ml-1 text-indigo-500">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                        </div>
                    </inertia-link>
                </div>

            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        Un Assigned Issues.
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="container flex">
                            <div class="rounded-full h-14 w-14 flex items-center justify-center border-4 border-indigo-700 font-semibold text-indigo-500 text-xl">
                                {{ unAssignedIssuesCount }}
                            </div>
                            <div class="flex items-center justify-center ml-4">
                                of {{ incompleteIssuesCount }} pending Issues.
                            </div>
                        </div>
                    </div>
                    <inertia-link :href="route('issues.index')">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Explore all Issues</div>
                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>

            </div>

            <div class="p-6 border-t border-gray-200">

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>

                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        Software Systems.
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="container flex">
                            <div class="rounded-full h-14 w-14 flex items-center justify-center border-4 border-indigo-700 font-semibold text-indigo-500 text-xl">
                                {{ systemsCount }}
                            </div>
                            <div class="flex items-center justify-center ml-4">
                                Supported Systems.
                            </div>
                        </div>
                    </div>
                    <inertia-link :href="route('systems.index')">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>Explore all Systems</div>
                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>

            </div>

            <div class="p-6 border-t border-gray-200 md:border-l">

                <div class="flex items-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        Developers.
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        <div class="container flex">
                            <div class="rounded-full h-14 w-14 flex items-center justify-center border-4 border-indigo-700 font-semibold text-indigo-500 text-xl">
                                {{ developersCount }}
                            </div>
                            <div class="flex items-center justify-center ml-4">
                                Skilled Developers.
                            </div>
                        </div>
                    </div>
                    <inertia-link :href="route('users.index', { role: 'developer' })">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>See all Developers</div>
                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo';

    export default {
        props : [ 'systemsCount', 'developersCount', 'incompleteIssuesCount', 'assignedIssuesCount', 'unAssignedIssuesCount'],
        components: {
            JetApplicationLogo
        },
    }
</script>
