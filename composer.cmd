@REM docker run --rm --interactive --tty --volume "%cd%\app:/app" composer install
@REM docker run --rm --interactive --tty --volume "%cd%\app:/app" composer update
docker-compose exec app bash
pause