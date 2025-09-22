<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Card, CardAction, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { createOrder as createOrderApi } from '@/lib/api'
import { ref } from 'vue'

const createOrder = async () => {
  await createOrderApi({
    title: title.value,
    total_price: total_price.value,
    image: image.value,
  }).catch((err: any) => {
    serverError.value = err.message ?? 'A server side error occurred'
  })
}

const title = ref('')
const total_price = ref(0)
const image = ref('')

const serverError = ref('')
</script>

<template>
  <Card class="min-w-md p-4 gap-2">
    <CardHeader class="p-0">
      <CardTitle>Enter order details</CardTitle>
    </CardHeader>

    <CardContent class="p-0 flex flex-col gap-4">
      <Input placeholder="Order title" v-model="title" />
      <Input placeholder="Total price" v-model="total_price" />
      <Input placeholder="Image url" v-model="image" />

      <p class="text-sm text-red-500">{{ serverError }}</p>
    </CardContent>

    <CardAction class="p-0 w-full">
      <Button class="w-full cursor-pointer" size="sm" @click="createOrder">Add Order</Button>
    </CardAction>
  </Card>
</template>
