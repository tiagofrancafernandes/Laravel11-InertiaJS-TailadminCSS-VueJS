<script setup lang="ts">
import { ref, computed } from 'vue'
import TableOne from '@/Components/Tables/TableOne.vue'
import TableTwo from '@/Components/Tables/TableTwo.vue'
import TableThree from '@/Components/Tables/TableThree.vue'
import CustomTable from '@/Components/Tables/CustomTable.vue'
// import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue';

const pageTitle = computed(() => 'Table');
const pageSubtitle = computed(() => 'Table');

const breadcrumbItems = [
    {
        label: pageTitle.value,
        href: '/profile',
    },
    {
        label: pageSubtitle.value,
    }
];

</script>

<template>
    <TailAdminLayout
        :pageTitle="pageTitle"
        :breadcrumbItems="breadcrumbItems"
    >

    <div class="flex flex-col gap-10">
      <!-- <CustomTable /> -->
      <!-- <TableOne /> -->
      <!-- <TableTwo /> -->
      <TableThree />
    </div>
  </TailAdminLayout>
</template>
