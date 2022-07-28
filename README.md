# La Nîmes'alerie
La Nîmes'alerie is an e-commerce website using Symfony, TypeScript, SCSS for my web developper training.

This is a fictional project using fakes informations. All datas you can find in this project are not real.


# Table of contents
* [Getting Started](#start)
    * [Prerequisites](#prerequisites)
    * [Installation](#installation)
        * [Setting-up the database](#setupdb)
        * [Setting-up the JWT Keys](#setupJk)
    * [API](#api)
        * [Access token](#apiToken)


# Getting Started <a name="start"></a>

## Prerequisites <a name="prerequisites"></a>
This project requires **Symfony** (5.4.12) , **openssl** (to generate public / private keys).


## Installation <a name="installation"></a>
Start cloning the repository in a directory :

```
git clone https://github.com/Will0u/lanimalerie-businessCase.git
```

Once installed, open a terminal and do the following command in the project directory to install depedencies of the project :
```
symfony composer install
```

### Setting-up the database <a name="setupdb"></a>
You will have to create a file called **.env.local** in the root of the project :
```
📦lanimalerie-businesscase
 ┣ 📂bin
 ┣ 📂...
 ┣ 📜.env
 ┣ 📜.env.local
 ┗ 📜...
```
And write in the file :
```
DATABASE_URL="mysql://root@127.0.0.1:3306/lanimalerie"
```
Or choose another **DATABASE_URL** according to your DBMS and configuration in the **.env** file.

Then, you have to create the database by using this command in a terminal :
```
symfony console doctrine:database:create
```
This will create the database but tables. To create tables, do this command in a terminal and answer **yes** at the question. :
```
symfony console doctrine:migrations:migrate
```

To add datas in the database, write this command in a terminal and answer **y** at the question. :
```
symfony console hautelook:fixtures:load --purge-with-truncate
```

### Setting-up the JWT Keys <a name="setupJk"></a>
You will need Openssl , if you don't have it you can download it [here](https://slproweb.com/products/Win32OpenSSL.html). These keys will allow you to have access to the API.

You will have to create a folder called **jwt** in the config folder :
```
📦lanimalerie-businesscase
 ┣ 📂bin
 ┣ 📂config
 ┃ ┗ 📂jwt
 ┃ ┗ 📂...
 ┣ 📜.env
 ┣ 📜.env.local
 ┗ 📜...
```
Generate the keys by doing this command in a terminal :
```
symfony console lexik:jwt:generate-keypair
```

## Access to the API <a name="api"></a>
Once the keys generated, you can start the project by using the `symfony serve` command in a terminal and go at this link : **localhost:8000/api/docs** OR another link according to your configuration.

### Access token <a name="apiToken"></a>
2 ways to have an access token :
* In **localhost:8000/api/docs** go to the **Token** section, then click on **try it out** and write valid email and password.
* In an API testing tool (as Postman), do a **POST** request on **localhost:8000/authentication_token** with valid email and password.





