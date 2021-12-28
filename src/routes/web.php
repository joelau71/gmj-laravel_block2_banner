<?php

use GMJ\LaravelBlock2Banner\Http\Controllers\ConfigController;
use GMJ\LaravelBlock2Banner\Http\Controllers\BlockController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => ["web", "auth"],
    "prefix" => "admin/element/{element_id}/gmj/laravel_block2_banner",
    "as" => "LaravelBlock2Banner."
], function () {
    Route::get("index", [BlockController::class, "index"])->name("index");
    Route::get("create", [BlockController::class, "create"])->name("create");
    Route::post("store", [BlockController::class, "store"])->name("store");
    Route::get("edit/{id}", [BlockController::class, "edit"])->name("edit");
    Route::patch("update/{id}", [BlockController::class, "update"])->name("update");

    Route::get("order", [BlockController::class, "order"])->name("order");
    Route::post("order2", [BlockController::class, "order2"])->name("order2");
    Route::delete("delete/{id}", [BlockController::class, "destroy"])->name("delete");

    Route::group(["prefix" => "config", "as" => "config."], function () {
        Route::get("create", [ConfigController::class, "create"])->name("create");
        Route::post("store", [ConfigController::class, "store"])->name("store");
        Route::get("edit", [ConfigController::class, "edit"])->name("edit");
        Route::patch("update", [ConfigController::class, "update"])->name("update");
    });
});
