<script setup lang="ts">
import {
  Card,
  CardHeader,
  CardTitle,
  CardContent,
  CardDescription,
} from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { CardAction } from '@/components/ui/card'

// icons
import { CircleDollarSign } from 'lucide-vue-next'
import { Clock8 } from 'lucide-vue-next'

const props = defineProps<{
  orders: any[]
}>()
</script>

<template>
  <div class="grid grid-cols-4 gap-4">
    <Card v-for="order in props.orders" class="p-0 overflow-hidden min-w-64 gap-0">
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
          <p class="text-sm">Total price: {{ order.total_price }} $</p>
        </div>
        <div class="flex gap-1 items-center">
          <Clock8 class="size-4" />
          <p class="text-sm">Placed at: {{ order.placed_at }}</p>
        </div>
      </CardContent>

      <CardAction class="flex flex-col gap-2 p-2 w-full border-t">
        <h1 class="text-sm">Mark as</h1>
        <div class="flex gap-2 w-full">
          <Button size="sm" class="bg-green-600 flex-1">Delivered</Button>
          <Button size="sm" class="bg-red-600 flex-1">Cancelled</Button>
        </div>
      </CardAction>
    </Card>
  </div>
</template>
