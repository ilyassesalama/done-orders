install:
	cd backend && composer install
	cd frontend && pnpm install

run:
	cd backend && composer run dev &
	cd frontend && pnpm dev