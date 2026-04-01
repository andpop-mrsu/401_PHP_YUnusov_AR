.PHONY: install serve migrate fresh

install:
	composer install
	@if [ ! -f .env ]; then cp .env.example .env; fi
	php artisan key:generate
	@if [ ! -f database/database.sqlite ]; then touch database/database.sqlite; fi
	php artisan migrate --force
	@echo ""
	@echo "✅ Установка завершена!"
	@echo "   Запустите сервер командой: make serve"
	@echo "   Затем откройте: http://localhost:8000"
	@echo ""

serve:
	php artisan serve

migrate:
	php artisan migrate

fresh:
	php artisan migrate:fresh
