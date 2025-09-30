<script setup lang="ts">
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AddOrder from '@/home/AddOrder.vue';
import Orders from '@/home/Orders.vue';
import { db } from '@/lib/firebase';
import { useOrdersStore } from '@/stores/orders';
import { ref as dbRef, equalTo, onValue, orderByChild, query } from 'firebase/database';
import { onMounted, onUnmounted, ref } from 'vue';

const activeTab = ref<'orders' | 'add-order'>('orders')
const ordersStore = useOrdersStore()

let unsubscribe: (() => void) | null = null

onMounted(() => {
  const ordersRef = dbRef(db, 'orders')
  const ordersQuery = query(ordersRef, orderByChild('status'), equalTo('new'))
  
  unsubscribe = onValue(ordersQuery, (snapshot) => {
    const data = snapshot.val()
    if (data) {
      const orders = Object.values(data) as any[]
      ordersStore.setOrders(orders)
    } else {
      ordersStore.setOrders([])
    }
  })
})

onUnmounted(() => {
  if (unsubscribe) {
    unsubscribe()
  }
})

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
