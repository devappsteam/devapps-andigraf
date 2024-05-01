<?php

use App\Http\Controllers\AssociateController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::auth([
    'register' => false
]);

Route::get('/', function () {
    return redirect(route('painel'));
});

Route::get('/home', function () {
    return redirect(route('painel'));
});

Route::prefix('/associe-se')->group(function () {
    Route::get('/', [AssociateController::class, 'public_create'])->name('associate.public.index');
    Route::post('/salvar', [AssociateController::class, 'public_store'])->name('associate.public.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/painel', [HomeController::class, 'index'])->name('painel');

    Route::prefix('/premio')->group(function () {
        Route::get('/', [AwardController::class, 'index'])->name('award.index');
        Route::get('/adicionar', [AwardController::class, 'create'])->name('award.create');
        Route::get('/editar/{uuid}', [AwardController::class, 'edit'])->name('award.edit');
        Route::post('/salvar', [AwardController::class, 'store'])->name('award.store');
        Route::put('/atualizar/{uuid}', [AwardController::class, 'update'])->name('award.update');
        Route::delete('/apagar', [AwardController::class, 'delete'])->name('award.delete');
    });

    Route::prefix('/categorias')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('product.category.index');
        Route::get('/adicionar', [ProductCategoryController::class, 'create'])->name('product.category.create');
        Route::get('/editar/{uuid}', [ProductCategoryController::class, 'edit'])->name('product.category.edit');
        Route::post('/salvar', [ProductCategoryController::class, 'store'])->name('product.category.store');
        Route::put('/atualizar/{uuid}', [ProductCategoryController::class, 'update'])->name('product.category.update');
        Route::delete('/apagar', [ProductCategoryController::class, 'delete'])->name('product.category.delete');
    });

    Route::prefix('/segmentos')->group(function () {
        Route::get('/', [SegmentController::class, 'index'])->name('segment.index');
        Route::get('/adicionar', [SegmentController::class, 'create'])->name('segment.create');
        Route::get('/editar/{uuid}', [SegmentController::class, 'edit'])->name('segment.edit');
        Route::post('/salvar', [SegmentController::class, 'store'])->name('segment.store');
        Route::put('/atualizar/{uuid}', [SegmentController::class, 'update'])->name('segment.update');
        Route::delete('/apagar', [SegmentController::class, 'delete'])->name('segment.delete');
    });

    Route::prefix('/taxas/{award}')->group(function () {
        Route::get('/', [RateController::class, 'index'])->name('rate.index');
        Route::post('/salvar', [RateController::class, 'store'])->name('rate.store');
        Route::put('/atualizar/{uuid}', [RateController::class, 'update'])->name('rate.update');
        Route::delete('/apagar', [RateController::class, 'delete'])->name('rate.delete');
    });

    Route::prefix('/associado')->group(function () {
        Route::get('/', [AssociateController::class, 'index'])->name('associate.index');
        Route::get('/adicionar', [AssociateController::class, 'create'])->name('associate.create');
        Route::get('/editar/{uuid}', [AssociateController::class, 'edit'])->name('associate.edit');
        Route::post('/salvar', [AssociateController::class, 'store'])->name('associate.store');
        Route::put('/atualizar/{uuid}', [AssociateController::class, 'update'])->name('associate.update');
        Route::delete('/apagar', [AssociateController::class, 'delete'])->name('associate.delete');
        Route::get('/usuario/{uuid}', [AssociateController::class, 'user'])->name('associate.user.index');
        Route::post('/usuario/{uuid}', [AssociateController::class, 'user_update'])->name('associate.user.update');
        Route::get('/newsletter', [AssociateController::class, 'newsletter'])->name('associate.newsletter');
        Route::post('/newsletter/send', [AssociateController::class, 'send_mail'])->name('associate.newsletter.send');
    });


    Route::prefix('/produto')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/adicionar', [ProductController::class, 'create'])->name('product.create');
        Route::get('/editar/{uuid}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/salvar', [ProductController::class, 'store'])->name('product.store');
        Route::put('/atualizar/{uuid}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/apagar', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/buscar', [ProductController::class, 'find_by_associate'])->name('product.find');
        Route::post('/exportar', [ProductController::class, 'export'])->name('product.export');
        Route::post('/etiquetas', [ProductController::class, 'ticket'])->name('product.ticket');
    });

    Route::prefix('/inscricao')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('enrollment.index');
        Route::get('/adicionar', [EnrollmentController::class, 'create'])->name('enrollment.create');
        Route::get('/editar/{uuid}', [EnrollmentController::class, 'edit'])->name('enrollment.edit');
        Route::get('/visualizar/{uuid}', [EnrollmentController::class, 'view'])->name('enrollment.view');
        Route::get('/imprimir/{uuid}', [EnrollmentController::class, 'print'])->name('enrollment.print');
        Route::get('/ficha/{uuid}', [EnrollmentController::class, 'registers'])->name('enrollment.registers');
        Route::post('/salvar', [EnrollmentController::class, 'store'])->name('enrollment.store');
        Route::put('/atualizar/{uuid}', [EnrollmentController::class, 'update'])->name('enrollment.update');
        Route::delete('/apagar', [EnrollmentController::class, 'delete'])->name('enrollment.delete');
    });

    Route::prefix('/usuario')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/adicionar', [UserController::class, 'create'])->name('user.create');
        Route::get('/editar/{uuid}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/salvar', [UserController::class, 'store'])->name('user.store');
        Route::put('/atualizar/{uuid}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/apagar', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::get('/minha-conta', [AssociateController::class, 'profile'])->name('associate.profile');

    Route::prefix('/relatorio')->group(function () {
        Route::get('/associados', [ReportController::class, 'associates'])->name('report.associate');
        Route::get('/associados/exportar', [ReportController::class, 'associate_export'])->name('report.associate.export');
        Route::get('/produtos', [ReportController::class, 'products'])->name('report.product');
        Route::post('/produtos/exportar', [ReportController::class, 'product_export'])->name('report.product.export');
        Route::get('/votos', [ReportController::class, 'votes'])->name('report.vote');
        Route::post('/votos/exportar', [ReportController::class, 'vote_export'])->name('report.vote.export');
    });
});
