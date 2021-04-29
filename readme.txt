**Pour faire fonctionner le projet en local :
git clone https://github.com/khediril/projet3.git
cd projet3
composer install
modifier le fichier .env 
symfony console doctrine:database:create
symfony console doctrine:schema:update
symfony console doctrine:fixtures:load
symfony serve -d
