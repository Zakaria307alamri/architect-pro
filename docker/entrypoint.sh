#!/usr/bin/env bash
set -e

PORT="${PORT:-8080}"
RUN_MIGRATIONS="${RUN_MIGRATIONS:-false}"

sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php artisan config:clear || true
  php artisan migrate --force
fi

exec apache2-foreground
