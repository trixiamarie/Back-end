<?php

use Illuminate\Support\Facades\Route;

Route::get('/listaattivita', function () {
    return view('listaattivita');
});

Route::get('/nuovaattivita/{id}', function () {
    $u = new stdClass();
    $u -> name = "Pippo";
    $u -> lastname = "Godzilla";
    $u -> city = "New York";
    return view('nuovaattivita', ['obj' => $u]);
});

Route::get('/modificaattivita', function () {
    return view('modificaattivita');
});

Route::get('/eliminaattivita', function () {
    return view('eliminaattivita');
});