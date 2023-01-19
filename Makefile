build:
	cd ./api && cp .env.example .env
	docker-compose build
	@make up
	docker exec api_hobby composer install
	docker exec api_hobby php artisan key:generate
	sleep 2
	docker exec api_hobby php artisan migrate:fresh --seed
up:
	docker-compose up -d
down:
	docker-compose down

