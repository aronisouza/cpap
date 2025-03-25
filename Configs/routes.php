<?php

// Arquivo de configuração de rotas
return [
    // Rotas básicas
    ['GET', '/', 'HomeController', 'index'],
    ['GET', '/users', 'UserController', 'index'],

    // Rotas para login
    ['GET', '/login', 'LoginController', 'index'],
    ['POST', '/login', 'LoginController', 'store'],
    ['GET', '/logout', 'LoginController', 'logout'],

    // Rotas com parâmetros
    ['GET', '/users/edit/{id}', 'UserController', 'edit'],
    ['POST', '/users/edit/{id}', 'UserController', 'update'],

    // Rotas para criação
    ['GET', '/users/create', 'UserController', 'create'],
    ['POST', '/users/create', 'UserController', 'store'],

    // Rota para deletar
    ['GET', '/users/delete/{id}', 'UserController', 'delete'],
    
    // Rotas para perfil do usuário
    ['GET', '/profile', 'ProfileController', 'index'],
    ['POST', '/profile/update', 'ProfileController', 'update'],
];