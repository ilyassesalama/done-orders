import { API_ORDERS_URL } from './endpoints'

export const getOrders = async () => {
  const response = await fetch(API_ORDERS_URL)
  return response.json()
}

export const createOrder = async (order: any) => {
  const response = await fetch(API_ORDERS_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(order),
  })
  return response.json()
}

export const updateOrderStatus = async (id: string, status: string) => {
  const response = await fetch(`${API_ORDERS_URL}/${id}?status=${status}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
    },
  })
  return response.json()
}
