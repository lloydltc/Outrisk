<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api', 'middleware' => 'authapi'] , function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
});

$router->group(["prefix" => "role"], function () use ($router) {
    $router->get("/", "RoleController@index");
    $router->post("/", "RoleController@store");
    $router->delete("/{id}", "RoleController@destroy");
});
$router->group(["prefix" => "user-role"], function () use ($router) {
    $router->get("/", "UserRoleController@usersWithRoles");
    $router->get("/role/{role}", "UserRoleController@usersWithRole");
    $router->get("/user-without-role", "UserRoleController@usersWithoutRole");
    $router->post("/give-role", "UserRoleController@userAssignRole");
    $router->post("/revoke-role", "UserRoleController@userRemoveRoleAs");

});

$router->group(["prefix" => "auth"], function () use ($router) {
    $router->post("logout", "AuthController@logout");
    $router->post("password-change", "AuthPasswordChangeController");
    $router->get("refresh", "AuthController@refresh");
    $router->get("me", "AuthController@me");
});
