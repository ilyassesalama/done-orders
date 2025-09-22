<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner'
import Home from '@/home/Home.vue'
</script>

<template>
  <Toaster />
  <div class="flex flex-col h-screen">
    <div class="flex items-center justify-center bg-[#f54e1e] p-4">
      <h1 class="text-white text-xl font-bold">Done orders</h1>
    </div>
    <Home />
  </div>
</template>

<style scoped></style>
