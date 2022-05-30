# To install this project follow the next steps
1. *composer instal*
2. in .env file edit the configuration for your db server (DATABASE_URL="mysql://root:@127.0.0.1:3306/url_minifier?serverVersion=5.7&charset=utf8mb4")
3. to create the database run next command *php bin/console doctrine:database:create*
4. to create tables run next command *php bin/console doctrine:migrations:migrate*
