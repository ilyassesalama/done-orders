import { API_ORDERS_URL, API_SEED_EXAMPLE_ORDERS_URL } from './endpoints'

const apiRequest = async (url: string, options?: RequestInit) => {
  const response = await fetch(url, options)
  const data = await response.json()
  
  if (!response.ok) {
    throw new Error(data.error || 'An error occurred')
  }
  
  return data
}

export const getOrders = async () => {
  return apiRequest(API_ORDERS_URL)
}

export const createOrder = async (order: any) => {
  return apiRequest(API_ORDERS_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(order),
  })
}

export const updateOrderStatus = async (id: string, status: string) => {
  return apiRequest(`${API_ORDERS_URL}/${id}?status=${status}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
    },
  })
}

export const seedExampleOrders = async () => {
  return apiRequest(API_SEED_EXAMPLE_ORDERS_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
  })
}
