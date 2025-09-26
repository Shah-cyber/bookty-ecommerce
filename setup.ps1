Write-Host "🚀 Starting Bookty Enterprise setup..." -ForegroundColor Cyan

docker compose up -d --build
docker exec -it bookty_app composer install

$appKey = docker exec -it bookty_app php artisan env:get APP_KEY
if ($appKey -match "base64:") {
    Write-Host "✅ APP_KEY already exists." -ForegroundColor Green
} else {
    docker exec -it bookty_app php artisan key:generate
}

docker exec -it bookty_app php artisan migrate --force
docker exec -it bookty_app php artisan storage:link

Write-Host "🎉 Setup complete! Visit http://localhost:8000" -ForegroundColor Green
