@echo off
echo Optimizando el proyecto para producción...

:: Optimizar Composer
call composer install --optimize-autoloader --no-dev

:: Limpiar archivos innecesarios
rd /s /q node_modules
rd /s /q tests
rd /s /q .git
rd /s /q .github
del .gitattributes
del .gitignore
del phpunit.xml
del webpack.mix.js
del vite.config.js
del package.json
del package-lock.json
del .editorconfig
del .env.example
del README.md

:: Limpiar cachés locales
del /q bootstrap\cache\*.php
del /q storage\framework\cache\*
del /q storage\framework\sessions\*
del /q storage\framework\views\*
del /q storage\logs\*

:: Crear directorios necesarios (por si acaso)
if not exist bootstrap\cache mkdir bootstrap\cache
if not exist storage\framework\cache mkdir storage\framework\cache
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\logs mkdir storage\logs

:: Generar caché para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo Proyecto optimizado para producción
pause