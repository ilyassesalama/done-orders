# Done Orders
This is an implementation of a combination of Vue.js and PHP with Firebase to store and get food orders, basically, a CRUD app.

### Backend
PHP, basic app with a single controller to handle fetching, updating, and deleting orders. It connects to Firebase using Kreait. Eveything in the backend is accessible through the frontend, no special endpoints that require using Postman or curl.

### Frontend
Vue.js, with Pinia for state management and shadcn for the UI, everything is structured in a single page with 2 tabs, to either see orders and manage them or add new orders.


## Getting Started
First, you have place `firebase-service-account.json` in the `backend/src` folder. Then, if you have using MacOS or Linux, you can simply run `make install` to install the dependencies for both the backend and the frontend. Finally, you can run `make run` to start the server.

That's it! You can now access the app at `http://localhost:5173`.

> [!IMPORTANT]  
> If you are going to use your own service account, you MUST add the following lines to your Realtime Database Rules:
> ```
> {
>   "rules": {
>     ...
>     "orders": {
>       ".indexOn": ["status"]
>     }
>   }
> }
> ```
> This is important to fetch orders by status.
>
> Additionally, you have to change the database URI in the `backend/src/Firebase.php` file to your own.