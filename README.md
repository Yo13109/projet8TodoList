# INSTALLATION DE L APPLICATION
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/11136261f5a848bdbeccdf4bc4610820)](https://app.codacy.com/gh/Yo13109/projet8TodoList/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)



# Installation de l'application 

1.git clone https://github.com/Yo13109/projet8TodoList.git
 2. composer install
 3. configure the BDD connection on the .env file
 4. start the Php server + the wamp folder 
 5. command -> symfony serve
 6. create a database -> symfony console doctrine:database:create
 7. Migrate the table to the database -> symfony console doctrine:migration:migrate
 8. You can load the datas into the database -> symfony console doctrine:fixtures:load
 9. launch the application