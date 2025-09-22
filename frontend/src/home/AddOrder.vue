<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Card, CardAction, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { createOrder as createOrderApi, seedExampleOrders as seedExampleOrdersApi } from '@/lib/api'
import { ListPlus, Loader2, Plus } from 'lucide-vue-next'
import { ref } from 'vue'

const emit = defineEmits<{
  handleOrderAdded: []
}>()

const createOrder = async () => {
  addingOrder.value = true
  await createOrderApi({
    title: title.value,
    total_price: total_price.value,
    image: image.value,
  }).catch((err: any) => {
    serverError.value = err.message ?? 'A server side error occurred'
  }).finally(() => {
    addingOrder.value = false
    emit('handleOrderAdded')
  })
}

const seedExampleOrders = async () => {
  seedingExampleOrders.value = true
  await seedExampleOrdersApi().catch((err: any) => {
    serverError.value = err.message ?? 'A server side error occurred'
  }).finally(() => {
    seedingExampleOrders.value = false
    emit('handleOrderAdded')
  })
}

const title = ref<string>('')
const total_price = ref<number | undefined>(undefined)
const image = ref<string>('')

const serverError = ref('')

const addingOrder = ref(false)
const seedingExampleOrders = ref(false)
</script>

<template>
  <Card class="min-w-md p-4 gap-2">
    <CardHeader class="p-0">
      <CardTitle>Enter order details</CardTitle>
    </CardHeader>

    <CardContent class="p-0 flex flex-col gap-4">
      <Input placeholder="Order title" v-model="title" />
      <Input placeholder="Total price" v-model="total_price" type="number" />
      <Input placeholder="Image url" v-model="image" type="url" />

      <p class="text-sm text-red-500">{{ serverError }}</p>
    </CardContent>

    <CardAction class="flex flex-col p-0 w-full gap-2">
      <Button class="w-full cursor-pointer" size="sm" @click="createOrder" :disabled="addingOrder">
        <template v-if="addingOrder">
          <Loader2 class="animate-spin" />
          Adding...
        </template>
        <template v-else>
          <Plus class="size-4" />
          Add Order
        </template>
      </Button>
      <Button variant="outline" class="w-full cursor-pointer" size="sm" @click="seedExampleOrders" :disabled="seedingExampleOrders">
        <template v-if="seedingExampleOrders">
          <Loader2 class="animate-spin" />
          Seeding...
        </template>
        <template v-else>
          <ListPlus class="size-4" />
          Seed example orders
        </template>
      </Button>
    </CardAction>
  </Card>
</template>
