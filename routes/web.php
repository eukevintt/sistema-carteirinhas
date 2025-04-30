<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembershipCardController;

use App\Http\Middleware\CheckAdminOrManagement;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/registrar', [AuthController::class, 'showRegistrationForm'])->name('auth.register.form');
    Route::post('/registrar', [AuthController::class, 'register'])->name('auth.register');

    Route::get('/esqueci-minha-senha', [AuthController::class, 'showForgotPasswordForm'])->name('auth.password.forgot.form');
    Route::post('/esqueci-minha-senha', [AuthController::class, 'resetPassword'])->name('auth.password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'home'])->name('home');

    Route::get('/perfil', [AuthController::class, 'profile'])->name('profile.view');
    Route::patch('/perfil', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::middleware([CheckAdminOrManagement::class])->group(function () {
        Route::prefix('/gestao/associados')->name('members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');

            Route::get('/novo', [MemberController::class, 'create'])->name('create');
            Route::post('/novo', [MemberController::class, 'store'])->name('store');

            Route::get('/editar/{member}', [MemberController::class, 'edit'])->name('edit');
            Route::patch('/editar/{member}', [MemberController::class, 'update'])->name('update');

            Route::get('/exportar/pdf', [MemberController::class, 'exportPDF'])->name('export.pdf');
            Route::get('/exportar/excel', [MemberController::class, 'exportExcel'])->name('export.excel');
            Route::get('/exportar/csv', [MemberController::class, 'exportCSV'])->name('export.csv');
            Route::get('/imprimir', [MemberController::class, 'print'])->name('print');

            Route::patch('/suspender/{member}', [MemberController::class, 'suspend'])->name('suspend');
            Route::patch('/reativar/{member}', [MemberController::class, 'reactivate'])->name('reactivate')->withTrashed();
            Route::delete('/deletar/{member}', [MemberController::class, 'destroy'])->name('destroy')->withTrashed();
        });

        Route::prefix('/gestao/dependentes')->name('dependents.')->group(function () {
            Route::get('/', [DependentController::class, 'index'])->name('index');

            Route::get('/novo', [DependentController::class, 'create'])->name('create');
            Route::post('/novo', [DependentController::class, 'store'])->name('store');

            Route::get('/editar/{dependent}', [DependentController::class, 'edit'])->name('edit');
            Route::put('/editar/{dependent}', [DependentController::class, 'update'])->name('update');

            Route::get('/exportar/pdf', [DependentController::class, 'exportPDF'])->name('export.pdf');
            Route::get('/exportar/excel', [DependentController::class, 'exportExcel'])->name('export.excel');
            Route::get('/exportar/csv', [DependentController::class, 'exportCSV'])->name('export.csv');
            Route::get('/imprimir', [DependentController::class, 'print'])->name('print');

            Route::patch('/suspender/{dependent}', [DependentController::class, 'suspend'])->name('suspend');
            Route::patch('/reativar/{dependent}', [DependentController::class, 'reactivate'])->name('reactivate')->withTrashed();
            Route::delete('/deletar/{dependent}', [DependentController::class, 'destroy'])->name('destroy')->withTrashed();
        });

        Route::prefix('/gestao/usuarios')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/detalhes/{user}', [UserController::class, 'show'])->name('show');

            Route::get('/novo', [UserController::class, 'create'])->name('create');
            Route::post('/novo', [UserController::class, 'store'])->name('store');

            Route::get('/editar/{user}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/editar/{user}', [UserController::class, 'update'])->name('update');

            Route::patch('/suspender/{user}', [UserController::class, 'suspend'])->name('suspend');
            Route::patch('/reativar/{user}', [UserController::class, 'reactivate'])->name('reactivate')->withTrashed();
            Route::delete('/deletar/{user}', [UserController::class, 'destroy'])->name('destroy')->withTrashed();
        });

        Route::prefix('/gestao/carteirinhas')->name('cards.')->group(function () {
            Route::get('/', [MembershipCardController::class, 'index'])->name('index');

            Route::delete('/deletar/{id}', [MembershipCardController::class, 'destroy'])->name('destroy');
        });
    });

    Route::get('/foto-perfil/{user}', [UserController::class, 'getProfilePhoto'])->name('users.photo');

    Route::prefix('/carteirinha')->name('cards.')->group(function () {
        Route::get('/{id}', [MembershipCardController::class, 'generateForMember'])->name('member.generate');
        Route::get('/dependente/{id}', [MembershipCardController::class, 'generateForDependent'])->name('dependent.generate');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
