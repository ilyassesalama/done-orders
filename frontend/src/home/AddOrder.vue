<script setup lang="ts">
import { Input } from '@/components/ui/input'
import { Card, CardHeader, CardTitle, CardContent, CardAction } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
</script>

<template>
  <Card class="min-w-md p-4">
    <CardHeader class="p-0">
      <CardTitle>Enter order details</CardTitle>
    </CardHeader>

    <CardContent class="p-0 flex flex-col gap-4">
      <Input placeholder="Order title" />
      <Input placeholder="Total price" />
      <Input placeholder="Image url" />
    </CardContent>

    <CardAction class="p-0 w-full">
      <Button class="w-full cursor-pointer" size="sm">Add Order</Button>
    </CardAction>
  </Card>
</template>
