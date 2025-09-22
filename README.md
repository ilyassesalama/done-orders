# Done Orders
## Intro
This is an implementation of a combination of Vue.js and PHP with Firebase to store and get food orders, basically, a CRUD app.

## Backend
PHP, basic app with a single controller to handle fetching, updating, and deleting orders. It connects to Firebase using `Kreait` library with a service account file `firebase-service-account.json` that must be placed under `/backend/src/` folder.
Eveything in the backend is accessible through the frontend, no need for using Postman.

## Frontend
Vue.js, with Pinia for state management and shadcn for the UI, everything is structured in a single page with 2 tabs, to either see orders and manage them or add new orders.
