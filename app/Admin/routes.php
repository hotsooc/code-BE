<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('/page', APageController::class);
    $router->resource('/section', ASectionController::class);
    $router->resource('/component', AComponentController::class);
    $router->resource('/class', AClassController::class);
    $router->resource('/document-type', ADocumentTypeController::class);
    $router->resource('/document', ADocumentController::class);
    $router->resource('/lecture-type', ALectureTypeController::class);
    $router->resource('/lecture', ALectureController::class);
    $router->resource('/news-category', ANewsCategoryController::class);
    $router->resource('/news', ANewsController::class);
    $router->resource('/feedback', AFeedbackController::class);
    $router->resource('/lecturer', ALecturerController::class);


});
