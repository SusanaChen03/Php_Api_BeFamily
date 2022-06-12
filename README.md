# Api RestFul BeFamily

## Tabla de contenido

-[Laravel BeFamily](#Laravel)

-[Introducción](#introducción) 

-[Stack Tecnológico](#StackTecnológico) ⚒

-[Descripción y Usabilidad](#Descripción) 📋

-[Tablas](#Tablas)

-[Relaciones](#Relaciones)

-[Endpoints](#Endpoints)

-[Instalación](#Instalación) 🍕

-[Autora](#Autora) 👩‍🦰

-[Como ayudar](#ComoAyudar) 🤞

-[Agradecimientos](#Agradecimientos) 👏


## Introducción 🌍
---
Esta es la Api elaborada con el lenguaje de PHP con el framework de Laravel, hay varias tablas acorde a las necesidades de la aplicación y en cada una de las tablas tienen su respectivo CRUD.

> Creación

> Traer datos

> Edición 

> Eliminar


## Stack Tecnológico ⚒
---
Las tecnologías utilizadas para la realización del Front han sido:

<p align="left">
    <a href="https://laravel.com/" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="Laravel Logo" width="40" height="40"/> 
    </a> 
    <a href="https://www.php.net" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="PHP Logo" width="40" height="40"/> 
    </a> 
    <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/mysql/mysql.png" alt="MySQL Logo" width="40" height="40"> 
    </a> 
    <a href="https://git-scm.com/" target="_blank" rel="noreferrer">
        <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="Git Logo" width="40" height="40"/>
    </a> 
    <a href="https://heroku.com" target="_blank" rel="noreferrer"> 
        <img src="https://www.vectorlogo.zone/logos/heroku/heroku-icon.svg" alt="Heroku Logo" width="40" height="40"/> 
    </a>
    <a href="https://postman.com" target="_blank" rel="noreferrer"> 
        <img src="https://www.vectorlogo.zone/logos/getpostman/getpostman-icon.svg" alt="Postman Logo" width="40" height="40"/> 
    </a>
    <a href="https://trello.com" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/trello/trello-plain-wordmark.svg" alt="Trello Logo" width="40" height="40"/> 
    </a>
</p>


## Descripción y Usabilidad 📋 
---

Heroku Url: 

Esta es la api creada para la aplicación de BeFamily conectada a una base de datos relacionada con MySQL.

Consta de una  rama `master` donde es la rama principal, de allí sacamos ramas con cada tabla para crear la usabilidad y cubrir las necesidades de cada una de ellas como serían `users` `challenges` `rewads` y una tabla intermedia `challenges-rewards` y mergeando a la master una vez acabada la funcionalidades bases como es el CRUD completo, luego las modificaciones que se han necesitado hacer mientras la elaboración del Front, están registradas en la rama master.

Además, para organizarme mejor he utilizado `Trello` como metodología Kanban, la cuál me ha ayudado mucho a organizar objetivos MVP, extras y tareas en progreso y ya realizadas. A continuación cito los objetivos MVP del proyecto:

* Los usuarios tienen que hacer un registro generando una autenticación con el nombre de la familia, correo y contraseña.

* Los usuarios tienen que logearse con la autentificación de correo y contraseña

* Los usuarios no pueden recorrer los endpoints si no está logeados.

* Los usuarios podrán ver sus retos, editarlos y eliminarlos. Estas funcionalidades sirven para las tablas de recompensas y la del perfil.



##  Tablas 
---

Cómo podéis observar he realizado 3 entidades referenciadas como Users, Challenges y Rewads, más la tabla intermedia entre Challenge y Reward.

- Tabla `User`:  
Contiene los datos necesarios de los usuarios para registrarse en el sistema.

- Tabla `Challenge`:
Contienen los datos de la creación de un reto.

- Tabla `Reward`:
Contiene los datos de la creación de la recompensa.

- Tabla intermedia `Challenge_Reward`:
Esta es la tabla intermedia que se genera con la relacion de muchos a muchos, dentro de esta se encuentran la clave forénea de esas dos.



## Relaciones 

Las relaciones entre las tablas son las siguientes:

```
- User vs Challenge  1:N
- User vs Reward 1:N
- Challenge vs reward  N:M
```

## Endpoints 
He separado los endpoint por grupo de las tablas para que a la hor de identificar y ver sean más legibles.
Cada grupo con su respectivo middleware.

### Auth
Los endpoints de autorización que necesitan la generación de token y el middleware cors se pone de esta manera en PHP para el correcto funcionamiento de las llamadas a los endpoints.

~~~
Route::group([
    'middleware' => ['cors']
], function(){
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
});


Route::group([
    'middleware' => 'jwt.auth'
], function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
});

~~~

*Route::post('/register', [AuthController::class, 'register']);   // Registro de nuevo usuario, creando un token de acceso.
``` json
{ 
    "familyName":"familyName",
    "userName":"YourName",
    "birthday": "YourBirthday",
    "email": "userEmail@userDomain.com",
    "password": "userPassword"
}
```

*Route::post('/login', [AuthController::class, 'login']);  // Logeo de un usuario, creando un token de acceso.
``` json
{ 
  "email": "userEmail@userDomain.com",
  "password": "userPassword",
}
```

*Route::post('/logout', [AuthController::class, 'logout']);  // Logout del usuario, pasando el token por el body.
``` json
{ 
  "token": "token generated",
}
```
*Route::get('/profile', [AuthController::class, 'profile']); // Devuelve los datos del usuario logeado


### Users

~~~
Route::group([
    'middleware' => ['jwt.auth', 'cors']
], function(){
Route::post('/user', [UserController::class, 'createUser']);  
Route::get('/users', [UserController::class, 'getAllUsers']);    
Route::get('/user/{id}', [UserController::class, 'getUserById']); 
Route::patch('/user/{id}', [UserController::class, 'updateUserById']);   
Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);   
});
~~~

* Route::post('/user', [UserController::class, 'createUser']);  // Con el Id logeado el usuario.
en este caso el endpoint esta presente pero no se utiliza porque ya tenemos el de registro.

* Route::get('/users', [UserController::class, 'getAllUsers']);   // Devuelve todos los usuarios creados por el usuario.
en este caso tampoco lo utilizaremos porque tenemos un apartados para los miembros de la familia.

* Route::get('/user/{id}', [UserController::class, 'getUserById']);   // Busca el usuario por el id indicado por parametro.

* Route::patch('/user/{id}', [UserController::class, 'updateUserById']);   // Buscar el usuario por su id y puede editar datos.

* Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);  // Borra el id encontrándolo por su id.


### Members

~~~
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/member', [MemberController::class, 'createUserMember']);  
Route::get('/members/{familyName}', [MemberController::class, 'getAllMembers']);  
});
~~~


* Route::post('/member', [MemberController::class, 'createUserMember']);    //  Con el usuario logeado crea a los miembros de la familia.
``` json
{
    "name": "memberName",
    "birthday": "YourBirthday",
    "email": "userEmail@userDomain.com",
    "password": "userPassword"
}
```

* Route::get('/members/{familyName}', [MemberController::class, 'getAllMembers']);   // Devuelve todos los miembros registrados con el mismo nombre de familia.



### Challenge
~~~
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/challenge', [ChallengeController::class, 'createChallenge']); 
Route::get('/challenges', [ChallengeController::class, 'getAllChallenges']);     
Route::get('/challenge/familyName/{familyName}', [ChallengeController::class, 'getAllChallengeByFamilyName']);    
Route::get('/challenge/{id}', [ChallengeController::class, 'getChallengeById']);  
Route::patch('/challenge/{id}', [ChallengeController::class, 'updateChallengeById']);   
Route::delete('/challenge/{id}', [ChallengeController::class, 'deleteChallengeById']);   
});
~~~

* Route::post('/challenge', [ChallengeController::class, 'createChallenge']);   // Crea un nuevo reto

``` json
{
    "familyName": "familyName",
    "members": "membersToParticipe",
    "repeat": "numberOfRepetition",
    "reward": "selectReward"
}
```

* Route::get('/challenges', [ChallengeController::class, 'getAllChallenges']);  // Devuelve todos los retos del usuario logeado.

* Route::get('/challenge/familyName/{familyName}', [ChallengeController::class, 'getAllChallengeByFamilyName']);  // Devuelve todos los retos registrados con ese nombre de familia

* Route::get('/challenge/{id}', [ChallengeController::class, 'getChallengeById']);  // Devuelve el reto registrado con ese id.

* Route::patch('/challenge/{id}', [ChallengeController::class, 'updateChallengeById']);   // Edita los datos del reto por el id indicado.

* Route::delete('/challenge/{id}', [ChallengeController::class, 'deleteChallengeById']); // Elimina el reto buscándolo por su id.


### Rewards

~~~
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/reward', [RewardController::class, 'createReward']);  
Route::get('/rewards', [RewardController::class, 'getAllRewards']); 
Route::get('/reward/{familyName}', [RewardController::class, 'getRewardByFamilyName']); 
Route::get('/reward/id/{id}', [RewardController::class, 'getRewardByIds']); 
Route::patch('/reward/{id}', [RewardController::class, 'updateRewardById']);   
Route::delete('/reward/{id}', [RewardController::class, 'deleteRewardById']);     
});
~~~


* Route::post('/reward', [RewardController::class, 'createReward']);   //Crea una recompensa
``` json
{
    "familyName": "familyName",
    "name": "rewardName",
    "image": "chooseImageUrl",
    "description": "description",
    "color": "selectColor"
}
```

* Route::get('/rewards', [RewardController::class, 'getAllRewards']);   //Devuelve todas las recompensas creadas.

* Route::get('/reward/{familyName}', [RewardController::class, 'getRewardByFamilyName']);   // Devuleve todas la recompensas creadas por el mismo nombre de familia.

* Route::get('/reward/id/{id}', [RewardController::class, 'getRewardByIds'])  // Devuelve la recompensa por el id indicado.

* Route::patch('/reward/{id}', [RewardController::class, 'updateRewardById']);   // Edita los datos de una recompensa recogiendolo por su Id.

* Route::delete('/reward/{id}', [RewardController::class, 'deleteRewardById']);   //Elimina una recompensa por el id indicado.



# Instalación 

Para poder consumir la api es necesario lo siguiente:
- Clonar o forkear el repositorio si deseas, **Susana:** _(https://github.com/SusanaChen03/Php_Api_BeFamily.git)_.
- Instalar Composer: `https://getcomposer.org/download/`
- Hacer _composer install_ para cargar las dependencias del composer.json
- Atacar al API publicada en https://befamily-backend.herokuapp.com/ o como localhost si lo prefieres (es necesario cambiarlo en el .env)
- Revisar esta documentación.
- Puedes utilizarlo con el FrontEnd publicado en ... o atacar los endpoints en el postman.
- Conexión a internet



## Autora 👩‍🦰
---
* [Susana chen](https://github.com/susanachen03)



## Como ayudar 🤞
----
* Si deseas colaborar con éste proyecto u otro no dudes en contactar conmigo o solicitar una pull request.
* Mi correo electrónico: [grupochen@hotmail.com](mailto:grupochen@hotmail.com)
* Cualquier aporte se puede compensar en una quedada de cervezas o café para los que no beben cerveza. 


## Agradecimientos 👏
---
* Agradecer a *Jose Villanueva* por todo su tiempo, esfuerzo y paciencia para conseguir que cada día sea una mejor programadora.

* Gracias a la academia por enseñarme todo un mundo nuevo.

* Gracias a todos los usuario que se han leído mi readme hasta aquí, les invito que entren para probar mi aplicación.
  



