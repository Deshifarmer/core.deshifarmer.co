<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ChannelController;
use App\Http\Controllers\Api\v1\CompanyController;
use App\Http\Controllers\Api\v1\DiostributorInfoController;
use App\Http\Controllers\Api\v1\DistributorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\FarmerController;
use App\Http\Controllers\Api\v1\UnitController;
use App\Http\Controllers\Api\v1\UpazilaController;
use App\Http\Controllers\Api\v1\DistrictController;
use App\Http\Controllers\Api\v1\DivisionController;
use App\Http\Controllers\Api\v1\EmployeeController;
use App\Http\Controllers\Api\v1\FarmerDepositController;
use App\Http\Controllers\Api\v1\FarmersPointController;
use App\Http\Controllers\Api\v1\InputOrderController;
use App\Http\Controllers\Api\v1\MeController;
use App\Http\Controllers\Api\v1\OrdersController;
use App\Http\Controllers\Api\v1\ProductCategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\ProductSubCategoryController;
use App\Http\Controllers\Api\v1\UserController;
use App\Models\v1\Channel;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1/')
    ->middleware(['cors'])
    ->group(function () {

        Route::post('login', [AuthController::class, 'login']);


        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('division', [DivisionController::class, 'index']);
            Route::get('division/{division}', [DivisionController::class, 'show']);
            Route::get('district', [DistrictController::class, 'index']);
            Route::get('upazila', [UpazilaController::class, 'index']);
            Route::get('upazila', [UpazilaController::class, 'index']);
            Route::get('unit', [UnitController::class, 'index']);
            Route::post('unit', [UnitController::class, 'store']);

            Route::get('all_category', [ProductCategoryController::class, 'index']);
            Route::get('sub_category', [ProductSubCategoryController::class, 'index']);
            Route::Post('sub_category', [ProductSubCategoryController::class, 'store']);

            Route::get('all_product', [ProductController::class, 'index']);
            Route::get('product/sort', [ProductController::class, 'sort']);
        });


        //all route only for HeadQuater
        Route::group(['middleware' => ['auth:sanctum', 'user-access:HQ']], function () {
            Route::prefix('hq/')
                ->group(function () {
                    Route::post('add', [AuthController::class, 'register'])->name('add_hq_co_dis_me');
                    Route::get('all_company', [UserController::class, 'allCompany'])->name('all_company');
                    Route::get('all_distributor', [UserController::class, 'allDistributor'])->name('all_distributor');
                    Route::get('unassigned_distributor', [UserController::class, 'unassignedDistributor'])->name('unassigned_distributor');
                    Route::get('unassigned_me', [UserController::class, 'unassignedMe'])->name('unassigned_me');
                    Route::get('all_me', [UserController::class, 'allMicroEnt'])->name('all_me');
                    Route::get('all_channel', [ChannelController::class, 'index'])->name('hq.all_channel');
                    Route::get('info/{user}', [UserController::class, 'show'])->name('hq.info.single_user');
                    //Channel
                    Route::post('add_channel', [ChannelController::class, 'store']);
                    Route::get('channel/{channel}', [ChannelController::class, 'show'])->name('hq.single_channel');
                    Route::post('channel/{channel}/assign', [ChannelController::class, 'assign'])->name('hq.channel_assign');
                    Route::post('add_category', [ProductCategoryController::class, 'store'])->name('add_category');
                    Route::get('all_input_order', [InputOrderController::class, 'index'])->name('hq.all_input_order');
                });
        });
        //all route only for HeadQuater
        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO|HQ']], function () {
            Route::post('add_product', [ProductController::class, 'store'])->name('add_product');
        });

        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO']], function () {
            Route::prefix('co/')
                ->group(function () {
                    Route::get('my_product', [ProductController::class, 'companyWiseProduct'])->name('companyWiseProduct');
                });
        });

        Route::group(['middleware' => ['auth:sanctum', 'user-access:ME']], function () {
            Route::prefix('me/')
                ->group(function () {
                   Route::post('add_farmer', [FarmerController::class, 'store'])->name('me.add_farmer');
                   Route::get('my_farmer', [MeController::class, 'myFarmer'])->name('me.my_farmer');
                   Route::post('input_order', [InputOrderController::class, 'store'])->name('me.input_order');
                });
        });




        // All  route for HQ

        Route::prefix('product')
            ->group(function () {

                // Route::post('/', [ProductController::class, 'store']);
                Route::get('/{product}', [ProductController::class, 'show']);
                Route::put('/{product}', [ProductController::class, 'update']);
                Route::delete('/{product}', [ProductController::class, 'destroy']);
            });
        Route::prefix('company')
            ->group(function () {
                Route::get('/', [CompanyController::class, 'index']);
                Route::post('/', [CompanyController::class, 'store']);
                Route::get('/{company}', [CompanyController::class, 'show']);
                Route::get('/{company}/orders', [CompanyController::class, 'companyOrders']);
                // Route::put('/{product}', [CompanyController::class, 'update']);
                // Route::delete('/{product}', [CompanyController::class, 'destroy']);
            });
        Route::prefix('channel')
            ->group(function () {
                Route::get('/', [ChannelController::class, 'index']);


                Route::put('/{channel}', [ChannelController::class, 'update']);
                Route::delete('/{channel}', [ChannelController::class, 'destroy']);
            });

        Route::prefix('employee')
            ->group(function () {
                Route::get('/', [EmployeeController::class, 'index']);
                Route::post('/', [EmployeeController::class, 'store']);
                Route::get('/{employee}', [EmployeeController::class, 'show']);
                Route::put('/{employee}', [EmployeeController::class, 'update']);
                Route::delete('/{employee}', [EmployeeController::class, 'destroy']);
            });
        Route::prefix('farmer')
            ->group(function () {
                Route::get('/', [FarmerController::class, 'index']);
                // Route::post('/', [FarmerController::class, 'store']);
                Route::get('/{farmar}', [FarmerController::class, 'show']);
                Route::put('/{farmer}', [FarmerController::class, 'update']);
                Route::delete('/{farmer}', [FarmerController::class, 'destroy']);
            });




        Route::prefix('distributor')
            ->group(function () {
                Route::get('/my_me', [DistributorController::class, 'myMe']);
                Route::get('/', [DistributorController::class, 'index']);
                // Route::get('/{distributor}', [DistributorController::class, 'show']);
                Route::get('/info', [DiostributorInfoController::class, 'index']);
                Route::post('/info', [DiostributorInfoController::class, 'store']);
            });

        //All routes for Micro Entreprenur
        Route::prefix('me')
            ->group(function () {
                Route::get('/', [MeController::class, 'index']);
                Route::post('/', [MeController::class, 'store']);
                Route::get('/{me}', [MeController::class, 'show']);
                Route::put('/{me}', [MeController::class, 'update']);
                Route::delete('/{me}', [MeController::class, 'destroy']);
            });
        Route::prefix('input_order')
            ->group(function () {
                // Route::get('/', [InputOrderController::class, 'index']);

                Route::get('/{input_order}', [InputOrderController::class, 'show']);
                Route::put('/{input_order}', [InputOrderController::class, 'update']);
                Route::delete('/{input_order}', [InputOrderController::class, 'destroy']);
            });
        Route::prefix('order')
            ->group(function () {
                Route::get('/', [OrdersController::class, 'index']);
                Route::post('/', [OrdersController::class, 'store']);
                Route::get('/me/{id}', [OrdersController::class, 'orderFromMe']);
                Route::get('/farmer/{id}', [OrdersController::class, 'orderFromFarmer']);
                Route::get('/{order}', [OrdersController::class, 'show']);
                // Route::put('/{order}', [OrderFromMeController::class, 'update']);
                // Route::delete('/{order}', [OrderFromMeController::class, 'destroy']);
            });

        Route::prefix('farmer')
            ->group(function () {
                Route::get('/', [FarmerController::class, 'index']);
                Route::post('/', [FarmerController::class, 'store']);
                Route::get('/{farmer}', [FarmerController::class, 'show']);
                Route::put('/{farmer}', [FarmerController::class, 'update']);
                Route::delete('/{farmer}', [FarmerController::class, 'destroy']);
            });

        Route::prefix('farmers_point')
            ->group(function () {
                Route::get('/', [FarmersPointController::class, 'index']);
                Route::post('/', [FarmersPointController::class, 'store']);
                Route::get('/{farmers_point}', [FarmersPointController::class, 'show']);
                Route::put('/{farmers_point}', [FarmersPointController::class, 'update']);
                Route::delete('/{farmers_point}', [FarmersPointController::class, 'destroy']);
            });
        // Route::prefix('distributor')
        //     ->group(function () {

        //         Route::post('/', [DistributorInfoController::class, 'store']);
        //         Route::get('/{distributor}', [DistributorInfoController::class, 'show']);
        //         Route::put('/{distributor}', [DistributorInfoController::class, 'update']);
        //         Route::delete('/{distributor}', [DistributorInfoController::class, 'destroy']);
        //     });
        Route::prefix('farmer_deposit')
            ->group(function () {
                Route::get('/', [FarmerDepositController::class, 'index']);
                Route::post('/', [FarmerDepositController::class, 'store']);
                Route::get('/{farmer_deposit}', [FarmerDepositController::class, 'show']);
                Route::put('/{farmer_deposit}', [FarmerDepositController::class, 'update']);
                Route::delete('/{farmer_deposit}', [FarmerDepositController::class, 'destroy']);
            });
    });
