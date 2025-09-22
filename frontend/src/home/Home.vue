<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import AddOrder from '@/home/AddOrder.vue'
import Orders from '@/home/Orders.vue'

import { getOrders } from '@/lib/api'
import { onMounted, ref } from 'vue'
const orders = ref<any[]>([])
const loading = ref(false)
const error = ref<string | null>(null)

onMounted(async () => {
  try {
    loading.value = true
    orders.value = await getOrders()
  } catch (err: any) {
    error.value = err.message ?? 'Failed to fetch orders'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="p-4">
    <Tabs default-value="orders" class="w-full flex justify-center items-center">
      <TabsList class="w-full max-w-md">
        <TabsTrigger value="orders"> Orders </TabsTrigger>
        <TabsTrigger value="add-order"> Add Order </TabsTrigger>
      </TabsList>

      <TabsContent value="orders">
        <Orders :orders="orders" />
      </TabsContent>
      <TabsContent value="add-order">
        <AddOrder />
      </TabsContent>
    </Tabs>
  </div>
</template>
