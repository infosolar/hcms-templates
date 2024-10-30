<?php

use App\Hcms\src\Enums\AccessScopes;
use App\Hcms\src\Http\Controllers\AdministratorAuthAuthController;
use App\Hcms\src\Http\Controllers\TemplatesController;
use App\Hcms\src\Http\Middleware\AdministratorOnly;
use App\Hcms\src\Http\Middleware\PermissionGranted;
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::prefix('hcms')
            ->name('hcms.')
            ->group(function () {
                Route::post('authenticate', [AdministratorAuthAuthController::class, 'authenticate']);

                Route::middleware(['auth:sanctum', AdministratorOnly::class])
                    ->group(function () {
                        Route::prefix('templates')
                            ->controller(TemplatesController::class)
                            ->group(function () {
                                Route::middleware(PermissionGranted::class . ':' . AccessScopes::TEMPLATES_INDEX->value)
                                    ->group(function () {
                                        Route::get('', 'index');
                                        Route::get('{id}', 'show');
                                    });

                                Route::post('', 'store')
                                    ->middleware(
                                        PermissionGranted::class . ':' . AccessScopes::TEMPLATE_CREATE->value
                                    );

                                Route::put('{id}', 'update')
                                    ->middleware(
                                        PermissionGranted::class . ':' . AccessScopes::TEMPLATE_EDIT->value
                                    );
                                Route::delete('{id}', 'destroy')
                                    ->middleware(
                                        PermissionGranted::class . ':' . AccessScopes::TEMPLATE_DELETE->value
                                    );
                                Route::delete('{id}/field', 'destroyField')
                                    ->middleware(
                                        PermissionGranted::class . ':' . AccessScopes::TEMPLATE_EDIT->value
                                    );
                            });
                    });
            });
    });


