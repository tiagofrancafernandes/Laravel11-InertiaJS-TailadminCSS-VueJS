<?php

Route::get(
    '/{home?}',
    fn () => 'This is the index of tenant ' . tenant('id') . ' ln~' . __FILE__ . ':' . __LINE__,
)
->where('home', 'home')
->name('tenant_path_home');

Route::get('/foo', fn () => 'Current URI: ' . Route::getCurrentRoute()?->uri . ' Tenenat ID:' . tenant('id') . ' ln~' . __FILE__ . ':' . __LINE__)->name('foo');

Route::get('/another', fn () => 'Current URI: ' . Route::getCurrentRoute()?->uri . ' Tenenat ID:' . tenant('id') . ' ln~' . __FILE__ . ':' . __LINE__)->name('another');

Route::get('/users', function () {
    dd(App\Models\User::all());

    return 'Current URI: ' . Route::getCurrentRoute()?->uri . ' Tenenat ID:' . tenant('id') . ' ln~' . __FILE__ . ':' . __LINE__;
})->name('users');
