<script setup lang="ts">
import ChartOne from '@/Components/Charts/ChartOne.vue'
import ChartThree from '@/Components/Charts/ChartThree.vue'
import ChartTwo from '@/Components/Charts/ChartTwo.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'

import { ref } from 'vue'

const pageTitle = ref('Basic Chart')
</script>

<template>
  <TailAdminLayout>
    <! -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
      <!-- ====== Chart One Start -->
      <ChartOne />
      <!-- ====== Chart One End -->

      <!-- ====== Chart Two Start -->
      <ChartTwo />
      <!-- ====== Chart Two End -->

      <!-- ====== Chart Three Start -->
      <ChartThree />
      <!-- ====== Chart Three End -->
    </div>
  </TailAdminLayout>
</template>
