<script setup lang="ts">
import * as StringHelpers from '@/Libs/Helpers/StringHelpers';
import HeaderArea from '@/Components/Header/HeaderArea.vue';
import Breadcrumb from '@/Components/Header/Breadcrumb.vue';
import SidebarArea from '@/Components/Sidebar/SidebarArea.vue';
import { computed } from "vue";
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    breadcrumbItems: {
        type: Array,
    },
    hideBreadcrumb: {
        type: Boolean,
        default: false,
    },
    pageTitle: {
        type: String,
        default: null,
    },
    hidePageTitle: {
        type: Boolean,
        default: false,
    },
    pageSubtitle: {
        type: String,
        default: null,
    },
});

const pageTitle = computed(() => {
    return props.pageTitle || StringHelpers.toTitle((new URL(location.href)).pathname);
});

const pageSubtitle = computed(() => {
    // (new URL(location.href)).pathname
    return props.pageSubtitle || '';
});

const hideBreadcrumb = computed(() => props.hideBreadcrumb);
const hidePageTitle = computed(() => Boolean(props.hidePageTitle));

const breadcrumbItems = computed(() => props.breadcrumbItems || [
    // {
    //     label: 'Abc',
    //     class: null,
    //     href: '#Abc',
    //     icon: `<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    //             <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
    //             </svg>`,
    // },
]);

/*
const breadcrumbItems = computed(() => [
    {
        label: 'Abc',
        class: null,
        href: '#Abc',
        icon: `<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>`,
    },
    {
        label: 'Def',
        class: null,
        href: '#Def',
        icon: `<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>`,
    },
    {
        label: 'Ghi',
        class: {
            //
        },
        href: null,
        icon: null,
    },
]);
*/

console.log('breadcrumbItems', breadcrumbItems.value);
</script>

<template>
    <Head :title="pageTitle" />

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <SidebarArea />
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            <!-- ===== Header Start ===== -->
            <HeaderArea />

            <!-- Page Heading -->
            <div class="bg-white dark:bg-gray-800 shadow" if="$slots.header">
                <Breadcrumb
                    :hide="hideBreadcrumb"
                    :items="breadcrumbItems"
                />

                <div
                    class="max-w-full mx-auto px-4 sm:px-6 lg:px-8"
                    :class="{
                        'py-6': pageTitle,
                        'py-8': !pageTitle,
                    }"
                    v-if="$slots.header"
                >
                    <slot name="header" />
                </div>
                <template v-else>
                    <div
                        class="max-w-full mx-auto px-4 sm:px-6 lg:px-8"
                        :class="{
                            'py-6': pageTitle,
                            'py-12': !pageTitle,
                        }"
                    >
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" v-text="pageTitle"></h2>
                        <h4 class=" leading-tight" v-text="pageSubtitle"></h4>
                    </div>
                </template>
            </div>

            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
            <div class="mx-auto max-w-screen-7xl p-4 md:p-6 2xl:p-10">
                <slot></slot>
            </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
    </div>
    <!-- ===== Page Wrapper End ===== -->
</template>
