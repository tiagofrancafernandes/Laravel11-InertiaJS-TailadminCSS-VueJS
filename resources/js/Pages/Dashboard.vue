<script setup>
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue';
import DataStatsOne from '@/Components/DataStats/DataStatsOne.vue'
import ChartOne from '@/Components/Charts/ChartOne.vue'
import ChartThree from '@/Components/Charts/ChartThree.vue'
import ChartTwo from '@/Components/Charts/ChartTwo.vue'
import ChatCard from '@/Components/ChatCard.vue'
import MapOne from '@/Components/Maps/MapOne.vue'
import TableOne from '@/Components/Tables/TableOne.vue'

const pageTitle = computed(() => 'Dashboard');
const pageSubtitle = computed(() => '');

</script>

<template>
    <Head :title="pageTitle" />

    <TailAdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" v-text="pageTitle"></h2>
            <h4 class=" leading-tight" v-text="pageSubtitle"></h4>
        </template>

        <div class="py-12 mb-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
                <DataStatsOne />
            </div>

            <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
                <!-- ====== Chart One Start -->
                <ChartOne />
                <!-- ====== Chart One End -->

                <!-- ====== Chart Two Start -->
                <ChartTwo />
                <!-- ====== Chart Two End -->

                <!-- ====== Chart Three Start -->
                <ChartThree />
                <!-- ====== Chart Three End -->

                <!-- ====== Map One Start -->
                <MapOne />
                <!-- ====== Map One End -->

                <!-- ====== Table One Start -->
                <div class="col-span-12 xl:col-span-8">
                    <TableOne />
                </div>
                <!-- ====== Table One End -->

                <!-- ====== Chat Card Start -->
                <ChatCard />
                <!-- ====== Chat Card End -->
            </div>
        </div>
    </TailAdminLayout>
</template>
