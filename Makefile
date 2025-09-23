install:
	cd backend && composer install
	cd frontend && pnpm install

run: check-service-account
	cd backend && php -S localhost:8000 -t public public/index.php &
	cd frontend && pnpm dev

check-service-account:
	@if [ ! -f backend/src/firebase-service-account.json ]; then \
		echo "❌ Error: firebase-service-account.json not found!"; \
		echo "Please add firebase-service-account.json to backend/src folder before running the project."; \
		exit 1; \
	fi