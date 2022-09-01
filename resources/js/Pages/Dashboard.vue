<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <welcome :systems-count = "systemsCount"
                             :developers-count ="developersCount"
                             :incomplete-issues-count ="incompleteIssuesCount"
                             :assigned-issues-count ="assignedIssuesCount"
                             :un-assigned-issues-count ="unAssignedIssuesCount"
                    />

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        props: ['systemsCount', 'developersCount', 'incompleteIssuesCount', 'assignedIssuesCount', 'unAssignedIssuesCount'],
        components: {
            AppLayout,
            Welcome,
        },
        mounted() {
            document.title = 'Dashboard - ' + this.$page.props.appName;
        }

    }
</script>
