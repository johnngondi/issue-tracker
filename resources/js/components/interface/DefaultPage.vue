<template>

    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <default-index :title="title"
                                   :description="content"
                    >

                        <div class="block">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden  pt-4 pb-6 pl-11 pr-11 ">

                                        <slot></slot>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </default-index>

                </div>
            </div>
        </div>

    </app-layout>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DefaultIndex from "@/components/interface/DefaultIndex";
export default {
    props: ['title', 'content'],
    name: "DefaultPage",
    components: {DefaultIndex, AppLayout}
}
</script>

<style scoped>

</style>
