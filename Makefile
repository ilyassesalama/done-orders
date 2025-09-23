install:
	cd backend && composer install
	cd frontend && pnpm install

run:
	cd backend && php -S localhost:8000 -t public public/index.php &
	cd frontend && pnpm dev