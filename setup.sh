#!/bin/bash
echo "🚀 Starting Bookty Enterprise setup..."

docker compose up -d --build
docker exec -it bookty_app composer install

APP_KEY=$(docker exec -it bookty_app php artisan env:get APP_KEY | tr -d '\r')
if [[ $APP_KEY == base64:* ]]; then
    echo "✅ APP_KEY already exists."
else
    docker exec -it bookty_app php artisan key:generate
fi

docker exec -it bookty_app php artisan migrate --force
docker exec -it bookty_app php artisan storage:link

echo "🎉 Setup complete! Visit http://localhost:8000"
