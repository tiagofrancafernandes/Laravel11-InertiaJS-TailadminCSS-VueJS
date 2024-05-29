<script setup>
import { ref } from 'vue'
import ProfileCard from '@/Components/ProfileCard.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'

const pageTitle = ref('Profile')
</script>

<template>
  <TailAdminLayout>
    <div class="mx-auto max-w-242.5">
      <ProfileCard />
    </div>
  </TailAdminLayout>
</template>
