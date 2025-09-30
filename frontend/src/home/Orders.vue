<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { updateOrderStatus as updateOrderStatusApi } from '@/lib/api'
import { formatDate } from '@/lib/utils'
import { useOrdersStore } from '@/stores/orders'

import { AnimatePresence, motion } from 'motion-v'
import { ref } from 'vue'

// icons
import { CircleDollarSign, Clock8, Loader2, PackageCheck, PackageX } from 'lucide-vue-next'

const ordersStore = useOrdersStore()

const deliveredLoading = ref(new Set<string>())
const cancelledLoading = ref(new Set<string>())

const updateOrderStatus = async (id: string, status: string) => {
  const loadingSet = status === 'delivered' ? deliveredLoading.value : cancelledLoading.value

  loadingSet.add(id)
  await updateOrderStatusApi(id, status).finally(() => {
    loadingSet.delete(id)
  })
}
</script>

<template>
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <AnimatePresence mode="popLayout">
      <motion.div
        v-for="order in ordersStore.orders"
        :key="order.id"
        layout
        :initial="{ scale: 0.8, opacity: 0 }"
        :animate="{ scale: 1, opacity: 1 }"
        :exit="{ scale: 0, opacity: 0 }"
        :transition="{ type: 'spring', stiffness: 300, damping: 25 }"
      >
        <Card class="p-0 overflow-hidden sm:min-w-64 gap-0">
          <CardHeader class="p-0 relative h-40 overflow-hidden">
            <img :src="order.image" alt="Order" class="h-full w-full object-cover" />

            <div
              class="absolute bottom-0 w-full p-2 bg-gradient-to-t from-black to-transparent flex flex-col gap-1"
            >
              <CardTitle class="text-white">{{ order.title }}</CardTitle>
              <CardDescription class="text-gray-100">New order</CardDescription>
            </div>
          </CardHeader>

          <CardContent class="p-2 flex flex-col gap-2">
            <div class="flex gap-1 items-center">
              <CircleDollarSign class="size-4" />
              <p class="text-sm">Total price: {{ order.total_price }}$</p>
            </div>
            <div class="flex gap-1 items-center">
              <Clock8 class="size-4" />
              <p class="text-sm">Placed at: {{ formatDate(order.placed_at) }}</p>
            </div>
          </CardContent>

          <CardAction class="flex flex-col gap-2 p-2 w-full border-t">
            <h1 class="text-sm">Mark as</h1>
            <div class="flex gap-2 w-full">
              <Button
                size="sm"
                class="bg-green-600 flex-1 cursor-pointer"
                @click="updateOrderStatus(order.id, 'delivered')"
                :disabled="deliveredLoading.has(order.id)"
              >
                <template v-if="deliveredLoading.has(order.id)">
                  <Loader2 class="animate-spin inline-block mr-1" /> Loading...
                </template>
                <template v-else> <PackageCheck class="inline-block mr-1" /> Delivered </template>
              </Button>
              <Button
                size="sm"
                class="bg-red-600 flex-1 cursor-pointer"
                @click="updateOrderStatus(order.id, 'cancelled')"
                :disabled="cancelledLoading.has(order.id)"
              >
                <template v-if="cancelledLoading.has(order.id)">
                  <Loader2 class="animate-spin inline-block mr-1" /> Loading...
                </template>
                <template v-else> <PackageX class="inline-block mr-1" /> Cancelled </template>
              </Button>
            </div>
          </CardAction>
        </Card>
      </motion.div>
    </AnimatePresence>
  </div>
</template>
