<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import Orders from '@/home/Orders.vue'
import AddOrder from '@/home/AddOrder.vue'
</script>

<template>
  <div class="p-4">
    <Tabs default-value="orders" class="w-full flex justify-center items-center">
      <TabsList class="w-full max-w-md">
        <TabsTrigger value="orders"> Orders </TabsTrigger>
        <TabsTrigger value="add-order"> Add Order </TabsTrigger>
      </TabsList>

      <TabsContent value="orders">
        <Orders />
      </TabsContent>
      <TabsContent value="add-order">
        <AddOrder />
      </TabsContent>
    </Tabs>
  </div>
</template>
