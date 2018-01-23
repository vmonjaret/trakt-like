# trakt-like


## Installation

```
cd docker
cp .env.dist .env
docker-compose up -d --build
docker-compose exec php bash
composer install
exit
cd ../symfony
yarn install
yarn prod
```