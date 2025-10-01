# Done Orders

A full-stack application with real-time order management using Vue.js, PHP, and Firebase.

## Tech Stack

**Backend**: PHP, Bramus Router, Firebase Realtime Database  
**Frontend**: Vue 3, TypeScript, Pinia, Tailwind CSS, shadcn-vue

## Prerequisites

- PHP 8.2+
- Composer
- Node.js 20.19+ or 22.12+
- pnpm
- Firebase project with Realtime Database

Or if you have Docker installed, you don't need to install any of the above.

## Getting Started

### 1. Firebase Setup

1. Get your service account JSON from Project Settings → Service Accounts
2. Get your Realtime Database URL
3. Add this index rule to your Realtime Database:

```json
{
  "rules": {
    "orders": {
      ".indexOn": ["status"]
    }
  }
}
```

### 2. Backend Setup

```bash
cd backend
composer install
```

Create `.env`:

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
FIREBASE_SERVICE_ACCOUNT='{"type":"service_account","project_id":"..."}'
ALLOWED_ORIGIN=http://localhost:5173
```

Start server:

```bash
composer run dev
# Backend runs on http://localhost:8000
```

### 3. Frontend Setup

```bash
cd frontend
pnpm install
```

Create `.env` (optional):

```env
VITE_FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
```

Start dev server:

```bash
pnpm dev
# Frontend runs on http://localhost:5173
```

## Docker Setup (Optional)

Create `.env` files as described above, then if you have Make installed, you can run:

```bash
make up
```

or if you don't have Make installed, you can run `docker-compose up`.

Services:

- Backend: `http://localhost:8000`
- Frontend: `http://localhost:5173`

Stop services:

```bash
make down
```

or `docker-compose down`.

## API Endpoints

**Base URL**: `http://localhost:8000`

### Health Check

```
GET /
```

### Create Order

```
POST /orders
Content-Type: application/json

{
  "title": "Pizza",
  "total_price": 15.99,
  "image": "https://example.com/image.jpg"
}
```

### Update Order Status

```
PATCH /orders/{id}?status={status}
```

Status: `delivered` | `cancelled`

### Seed Sample Data

```
POST /orders/seed
```