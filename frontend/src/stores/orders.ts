import { defineStore } from 'pinia'

interface Order {
  id: string
  title: string
  image: string
  total_price: number
  placed_at: number
  delivered_at?: number
  cancelled_at?: number
  status: string
}

export const useOrdersStore = defineStore('orders', {
  state: () => ({
    orders: [] as Order[]
  }),
  actions: {
    setOrders(orders: Order[]) {
      this.orders = orders
    }
  }
})
