<!-- ![Alt text](https://github.com/jeseduardopi/skill4cars/blob/main/carstore/public/assets/images/skill4allasciiart.png?raw=true) -->
# PROJECT MANAGER

### Description:
This was made with PHP/Symfony to evaluate my skills with this awesome php framework.

### Requirements :
- Docker installed
  
### Instructions:
To see this small app, make a git clone in your local machine of this url:
- git clone https://github.com/jeseduardopi/project-manager.git.

Therefore, in the root project folder : 

- docker-compose up -d
- docker exec -it project_manager_php sh -c "cd html && composer install && php bin/console doctrine:database:create && php bin/console doctrine:schema:update --force --no-interaction && php bin/console doctrine:fixtures:load --no-interaction"

### Now, you should be ready to test this app !

<!-- TODO : -->
<!-- 1. Add create task form -->
<!-- 2. Fix add member in project form -->
