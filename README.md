![Alt text](https://github.com/jeseduardopi/skill4cars/blob/main/carstore/public/assets/images/skill4allasciiart.png?raw=true)
# MY TECHNICAL TEST WITH SKILLS4ALL

## Message to the team:
Hello there 👋

I really enjoyed this test and i hope to work with you guys!

### Description:
This was made with PHP/Symfony to evaluate my skills with this awesome php framework.

### Requirements :
- Docker installed
  
### Instructions:
To see this small app, make a git clone in your local machine of this url https://github.com/jeseduardopi/skill4cars.git.

Therefore, in the root project folder : 

- docker-compose up -d
- docker exec -it carstore_php sh -c "cd html && composer install && php bin/console doctrine:database:create && php bin/console doctrine:schema:update --force --no-interaction && php bin/console doctrine:fixtures:load --no-interaction"

Now, you should be ready to test this app !
