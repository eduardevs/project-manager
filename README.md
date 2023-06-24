![alt text](https://github.com/jeseduardopi/skill4cars/Skill4AllASCII.png?raw=true)
# MY TECHNICAL TEST WITH SKILL4ALL

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
- docker exec -it <container_name> /bin/bash -c "cd html && composer install && php bin/console doctrine:database:create && php bin/console doctrine:fixtures:load"

You should be ready to test this app !
