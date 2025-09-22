<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AddOrder from '@/home/AddOrder.vue';
import Orders from '@/home/Orders.vue';
import { ref } from 'vue';

const activeTab = ref<'orders' | 'add-order'>('orders')

const handleOrderAdded = () => {
  activeTab.value = 'orders'
}
</script>

<template>
  <div class="p-4">
    <Tabs v-model="activeTab" default-value="orders" class="w-full flex justify-center items-center">
      <TabsList class="w-full sm:max-w-md">
        <TabsTrigger value="orders"> Orders </TabsTrigger>
        <TabsTrigger value="add-order"> Add Order </TabsTrigger>
      </TabsList>

      <TabsContent value="orders" class="w-full max-w-7xl mx-auto">
        <Orders />
      </TabsContent>
      <TabsContent value="add-order" class="w-full sm:max-w-md mx-auto">
        <AddOrder @handleOrderAdded="handleOrderAdded" />
      </TabsContent>
    </Tabs>
  </div>
</template>
