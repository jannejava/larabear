<?php

$prefix = '\\Eastwest\\Publisher\\Http\\Controllers\\';

Route::get('publisher/session/check', ['uses' => $prefix . 'SessionController@check', 'as' => 'publisher.session.check']);

// admin.user kommer från Voyager
Route::group(['prefix' => 'publisher', 'middleware' => ['admin.user', 'reset.last.activity'], 'as' => 'publisher.'], function () use ($prefix) {
    Route::get('pages/create', ['uses' => $prefix . 'PageController@create', 'as' => 'pages.create']);
    Route::post('pages/create', ['uses' => $prefix . 'PageController@store', 'as' => 'pages.store']);
    Route::get('pages/content/{id}', ['uses' => $prefix . 'PageContentController@edit', 'as' => 'pages.content.edit']);
    Route::get('pages/{id}', ['uses' => $prefix . 'PageController@show', 'as' => 'pages.show']);
    Route::get('pages/{id}/edit', ['uses' => $prefix . 'PageController@edit', 'as' => 'pages.edit']);
    Route::delete('pages/{id}/delete', ['uses' => $prefix . 'PageController@destroy', 'as' => 'pages.delete']);
    Route::get('pages/{id}/{language}', ['uses' => $prefix . 'PageContentController@beginEditing', 'as' => 'pages.begin-editing']);
    Route::post('pages/content/{id}/publish', ['uses' => $prefix . 'PageContentController@publish', 'as' => 'pages.content.publish']);
    Route::get('', ['uses' => $prefix . 'PageController@index', 'as' => 'pages.index']);
});

Route::group(['prefix' => 'publisher', 'middleware' => ['admin.user', 'ajax.session.expired', 'reset.last.activity'], 'as' => 'publisher.'], function () use ($prefix) {
    Route::get('pages/{id}/container/{containerId}', $prefix . 'ContainerController@show')->name('container.show');
    Route::post('pages/{id}/component/{uuid}/child/add', $prefix . 'ChildComponentController@add')->name('component.add.child');
    Route::post('pages/{id}/component/{uuid}/child/{childUuid}/delete', $prefix . 'ChildComponentController@delete')->name('component.delete.child');
    Route::post('pages/{id}/component/{uuid}/child/{childUuid}/move', $prefix . 'ChildComponentController@move')->name('component.move.child');
    Route::get('pages/{id}/component/{uuid}/child/{childUuid}/show', $prefix . 'ChildComponentController@show')->name('component.show.child');
    Route::post('pages/{id}/component/{uuid}/child/{childUuid}', $prefix . 'ChildComponentController@store')->name('component.store.child');
    Route::post('pages/{id}/component/add', $prefix . 'ComponentController@add')->name('component.add');
    Route::get('pages/{id}/component/{uuid}/show', $prefix . 'ComponentController@show')->name('component.show');
    Route::get('pages/{id}/component/{uuid}/update', $prefix . 'ComponentController@update')->name('component.update');
    Route::post('pages/{id}/component/{uuid}/delete', $prefix . 'ComponentController@delete')->name('component.delete');
    Route::post('pages/{id}/component/{uuid}/move', $prefix . 'ComponentController@move')->name('component.move');
    Route::post('pages/{id}/component/{uuid}', $prefix . 'ComponentController@store')->name('component.store');
    Route::post('pages/content/{id}', ['uses' => $prefix . 'PageContentController@updateMetadata', 'as' => 'pages.content.update.meta']);
    Route::post('upload/media', ['uses' => $prefix . 'UploadMediaController@upload', 'as' => 'upload.media']);
});
