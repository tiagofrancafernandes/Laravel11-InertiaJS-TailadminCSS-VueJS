<script setup lang="ts">
import { ref } from 'vue'
import CalendarCard from '@/Components/CalendarCard.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'

const pageTitle = ref('Calendar')
</script>

<template>
  <TailAdminLayout>
    <div class="mx-auto max-w-7xl">
      <CalendarCard />
    </div>
  </TailAdminLayout>
</template>
