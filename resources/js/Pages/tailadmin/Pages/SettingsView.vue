<script setup lang="ts">
import { ref } from 'vue'
import SettingsCard from '@/Components/SettingsCard.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'

const pageTitle = ref('Settings Page')
</script>

<template>
  <TailAdminLayout>
    <div class="mx-auto max-w-full">
      <SettingsCard />
    </div>
  </TailAdminLayout>
</template>
