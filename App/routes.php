<?php
// app/routes.php

use Pecee\SimpleRouter\SimpleRouter;

// Set a default namespace for controller callbacks (so you don’t have to prepend "App\Controllers\" each time)
SimpleRouter::setDefaultNamespace('App\Controllers');

// Home page that lists articles (with pagination handled in the controller)
SimpleRouter::get('/', 'HomeController@index')->name('home');
SimpleRouter::get('/home', 'HomeController@index')->name('home');

// User authentication routes
SimpleRouter::get('/login', 'UserController@loginForm')->name('login.form');
SimpleRouter::post('/login', 'UserController@login')->name('login');
SimpleRouter::get('/signup', 'UserController@signupForm')->name('signup.form');
SimpleRouter::post('/signup', 'UserController@signup')->name('signup');
SimpleRouter::get('/logout', 'UserController@logout')->name('logout');
SimpleRouter::get('/admin/users', 'UserController@adminUserList')->name('admin.users');

// Article CRUD routes
SimpleRouter::get('/view/{id}', 'ArticleController@view')
    ->where(['id' => '[0-9]+'])
    ->name('article.view');

SimpleRouter::match(['get', 'post'], '/create', 'ArticleController@create')
    ->name('article.create');

SimpleRouter::match(['get', 'post'], '/edit/{id}', 'ArticleController@edit')
    ->where(['id' => '[0-9]+'])
    ->name('article.edit');
    SimpleRouter::match(['get', 'post'], '/editRole/{id}', 'UserController@editRole')
    ->where(['id' => '[0-9]+'])
    ->name('editRole');

SimpleRouter::post('/delete/{id}', 'ArticleController@delete')
    ->where(['id' => '[0-9]+'])
    ->name('article.delete');
    SimpleRouter::get('/not-found', 'PageController@notFound');
    SimpleRouter::get('/forbidden', 'PageController@notFound');
    
    SimpleRouter::error(function(Request $request, \Exception $exception) {
    
        switch($exception->getCode()) {
            // Page not found
            case 404:
                response()->redirect('/not-found');
            // Forbidden
            case 403:
                response()->redirect('/forbidden');
                default:
            response()->httpCode(500);
            echo "An unexpected error occurred.";
            break;
        }
        
    });