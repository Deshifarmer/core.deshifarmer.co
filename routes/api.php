<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CashInRequestController;
use App\Http\Controllers\Api\v1\ChannelController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\FarmerController;
use App\Http\Controllers\Api\v1\UnitController;
use App\Http\Controllers\Api\v1\UpazilaController;
use App\Http\Controllers\Api\v1\DistrictController;
use App\Http\Controllers\Api\v1\DivisionController;
use App\Http\Controllers\Api\v1\EmployeeAccountController;
use App\Http\Controllers\Api\v1\EmployeeController;
use App\Http\Controllers\Api\v1\FarmerDepositController;
use App\Http\Controllers\Api\v1\FarmersPointController;
use App\Http\Controllers\Api\v1\InputOrderController;
use App\Http\Controllers\Api\v1\MeController;
use App\Http\Controllers\Api\v1\OrdersController;
use App\Http\Controllers\Api\v1\ProductCategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\ProductSubCategoryController;
use App\Http\Controllers\Api\v1\TransactionController;
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

            Route::get('product/{product}', [ProductController::class, 'show']);
        });


        //all route only for HeadQuatre
        Route::group(['middleware' => ['auth:sanctum', 'user-access:HQ']], function () {
            Route::prefix('hq/')
                ->group(function () {
                    Route::post('add', [AuthController::class, 'register'])->name('add_hq_co_dis_me');
                    Route::get('all_company', [UserController::class, 'allCompany'])->name('all_company');
                    Route::get('all_distributor', [UserController::class, 'allDistributor'])->name('all_distributor');
                    Route::get('all_me', [UserController::class, 'allMicroEnt'])->name('all_me');
                    Route::get('all_farmer', [FarmerController::class, 'index']);
                    Route::get('unassigned_distributor', [UserController::class, 'unassignedDistributor'])->name('unassigned_distributor');
                    Route::get('unassigned_me', [UserController::class, 'unassignedMe'])->name('unassigned_me');
                    Route::get('all_channel', [ChannelController::class, 'index'])->name('hq.all_channel');
                    Route::get('profile/{employee}', [EmployeeController::class, 'show'])->name('hq.profile.single_user');
                    Route::post('add_channel', [ChannelController::class, 'store'])->name('hq.add_channel');
                    Route::get('channel/{channel}', [ChannelController::class, 'show'])->name('hq.single_channel');
                    Route::post('channel/{channel}/assign_dis', [ChannelController::class, 'assign'])->name('hq.channel_assign_dis');
                    Route::post('assign_me', [ChannelController::class, 'assignMe'])->name('hq.assign_me');
                    Route::get('distributor/{employee}/me', [EmployeeController::class, 'distributorsMe'])->name('distributors_me');
                    Route::post('add_category', [ProductCategoryController::class, 'store'])->name('add_category');

                    Route::get('all_input_order', [InputOrderController::class, 'index'])->name('hq.all_input_order');

                    Route::get('input_order/{input_order}', [InputOrderController::class, 'show'])->name('hq.single_input_order');

                    Route::get('distributor/{dis_id}/order', [OrdersController::class, 'distributorOrder'])->name('hq.distributor_order');
                    Route::get('me/{me_id}/order', [OrdersController::class, 'meOrder'])->name('hq.me_order');

                    Route::get('farmer/profile/{farmer}', [FarmerController::class, 'show']);
                    Route::get('distributor/all_cash_in_request', [CashInRequestController::class, 'index'])->name('hq.distributor_cash_in_request');
                    Route::put('distributor/cash_in_request/{cash_in_request}', [CashInRequestController::class, 'update'])->name('hq.distributor_cash_in_request_update');
                    Route::put('product/{product}', [ProductController::class, 'update'])->name('hq.product_update');
                });
        });

        //all route only for Company
        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO']], function () {
            Route::prefix('co/')
                ->group(function () {
                    Route::get('my_product', [ProductController::class, 'companyWiseProduct'])->name('companyWiseProduct');
                    Route::get('my_order', [OrdersController::class, 'my_order'])->name('co.my_order');
                });
        });

        //all route only for Distributor
        Route::prefix('distributor')
            ->group(function () {
                Route::group(['middleware' => ['auth:sanctum', 'user-access:DB']], function () {

                    Route::get('my_profile', [EmployeeController::class, 'myProfile'])->name('my_profile');
                    
                    Route::get('my_me', [EmployeeController::class, 'myMe'])->name('distributor.my_me');
                    Route::get('me_order', [InputOrderController::class, 'meOrder'])->name('distributor.me_order');
                    Route::get('me_order/{input_order}', [InputOrderController::class, 'input_order_details'])->name('dis.input_order_details');
                    Route::post('cash_in_request/', [CashInRequestController::class, 'store'])->name('dis.cash_in_request');
                    Route::get('my_cash_in_request/', [CashInRequestController::class, 'myCashInReq'])->name('dis.my_cash_in_request');

                    Route::put('me_order/{input_order}', [InputOrderController::class, 'update'])->name('dis.input_order_update');
                });
            });


        //all route only for Micro Entrepreneur
        Route::group(['middleware' => ['auth:sanctum', 'user-access:ME']], function () {
            Route::prefix('me/')
                ->group(function () {
                    Route::post('add_farmer', [FarmerController::class, 'store'])->name('me.add_farmer');
                    Route::get('my_farmer', [MeController::class, 'myFarmer'])->name('me.my_farmer');
                    Route::post('input_order', [InputOrderController::class, 'store'])->name('me.input_order.store');
                });
        });

        //all route for HeadQuatre and Company
        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO|HQ']], function () {
            Route::post('add_product', [ProductController::class, 'store'])->name('add_product');
        });






        // Route::prefix('employee_account')
        //     ->group(function () {
        //         Route::get('/', [EmployeeAccountController::class, 'index']);
        //         Route::post('/', [EmployeeAccountController::class, 'store']);
        //         Route::get('/{employee_account}', [EmployeeAccountController::class, 'show']);
        //         Route::put('/{employee_account}', [EmployeeAccountController::class, 'update']);
        //         Route::delete('/{employee_account}', [EmployeeAccountController::class, 'destroy']);
        //     });

        // Route::prefix('transaction')
        //     ->group(function () {
        //         Route::get('/', [TransactionController::class, 'index']);
        //         Route::post('/', [EmployeeAccountController::class, 'store']);
        //         Route::get('/{transaction}', [EmployeeAccountController::class, 'show']);
        //         Route::put('/{transaction}', [EmployeeAccountController::class, 'update']);
        //         Route::delete('/{transaction}', [EmployeeAccountController::class, 'destroy']);
        //     });
        // Route::prefix('cash_in_request')
        //     ->group(function () {
        //         Route::get('/', [CashInRequestController::class, 'index']);

        //         Route::get('/{cash_in_request}', [CashInRequestController::class, 'show']);
        //         // Route::put('/{cash_in_request}', [CashInRequestController::class, 'update']);
        //         Route::delete('/{cash_in_request}', [CashInRequestController::class, 'destroy']);
        //     });





        // // All  route for HQ

        // Route::prefix('product')
        //     ->group(function () {

        //         // Route::post('/', [ProductController::class, 'store']);
        //         Route::get('/{product}', [ProductController::class, 'show']);
        //         Route::put('/{product}', [ProductController::class, 'update']);
        //         Route::delete('/{product}', [ProductController::class, 'destroy']);
        //     });
        // Route::prefix('company')
        //     ->group(function () {
        //         Route::get('/', [CompanyController::class, 'index']);
        //         Route::post('/', [CompanyController::class, 'store']);
        //         Route::get('/{company}', [CompanyController::class, 'show']);
        //         Route::get('/{company}/orders', [CompanyController::class, 'companyOrders']);
        //         // Route::put('/{product}', [CompanyController::class, 'update']);
        //         // Route::delete('/{product}', [CompanyController::class, 'destroy']);
        //     });
        // Route::prefix('channel')
        //     ->group(function () {
        //         Route::get('/', [ChannelController::class, 'index']);
        //         Route::put('/{channel}', [ChannelController::class, 'update']);
        //         Route::delete('/{channel}', [ChannelController::class, 'destroy']);
        //     });

        // Route::prefix('employee')
        //     ->group(function () {
        //         Route::get('/', [EmployeeController::class, 'index']);
        //         Route::post('/', [EmployeeController::class, 'store']);
        //         Route::get('/{employee}', [EmployeeController::class, 'show']);
        //         Route::put('/{employee}', [EmployeeController::class, 'update']);
        //         Route::delete('/{employee}', [EmployeeController::class, 'destroy']);
        //     });
        // Route::prefix('farmer')
        //     ->group(function () {
        //         Route::get('/', [FarmerController::class, 'index']);
        //         // Route::post('/', [FarmerController::class, 'store']);
        //         Route::get('/{farmer}', [FarmerController::class, 'show']);
        //         Route::put('/{farmer}', [FarmerController::class, 'update']);
        //         Route::delete('/{farmer}', [FarmerController::class, 'destroy']);
        //     });




        // Route::prefix('distributor')
        //     ->group(function () {
        //         Route::get('/my_me', [DistributorController::class, 'myMe']);
        //         Route::get('/', [DistributorController::class, 'index']);
        //         // Route::get('/{distributor}', [DistributorController::class, 'show']);
        //         Route::get('/info', [DistributorInfoController::class, 'index']);
        //         Route::post('/info', [DistributorInfoController::class, 'store']);
        //     });

        //All routes for Micro Entrepreneur
        // Route::prefix('me')
        //     ->group(function () {
        //         Route::get('/', [MeController::class, 'index']);
        //         Route::post('/', [MeController::class, 'store']);
        //         Route::get('/{me}', [MeController::class, 'show']);
        //         Route::put('/{me}', [MeController::class, 'update']);
        //         Route::delete('/{me}', [MeController::class, 'destroy']);
        //     });
        // Route::prefix('input_order')
        //     ->group(function () {
        //         // Route::get('/', [InputOrderController::class, 'index']);

        //         Route::get('/{input_order}', [InputOrderController::class, 'show']);
        //         Route::put('/{input_order}', [InputOrderController::class, 'update']);
        //         Route::delete('/{input_order}', [InputOrderController::class, 'destroy']);
        //     });
        // Route::prefix('order')
        //     ->group(function () {
        //         Route::get('/', [OrdersController::class, 'index']);
        //         Route::post('/', [OrdersController::class, 'store']);
        //         Route::get('/me/{id}', [OrdersController::class, 'orderFromMe']);
        //         Route::get('/farmer/{id}', [OrdersController::class, 'orderFromFarmer']);
        //         Route::get('/{order}', [OrdersController::class, 'show']);
        //         // Route::put('/{order}', [OrderFromMeController::class, 'update']);
        //         // Route::delete('/{order}', [OrderFromMeController::class, 'destroy']);
        //     });

        // Route::prefix('farmer')
        //     ->group(function () {
        //         Route::get('/', [FarmerController::class, 'index']);
        //         Route::post('/', [FarmerController::class, 'store']);
        //         Route::get('/{farmer}', [FarmerController::class, 'show']);
        //         Route::put('/{farmer}', [FarmerController::class, 'update']);
        //         Route::delete('/{farmer}', [FarmerController::class, 'destroy']);
        //     });

        // Route::prefix('farmers_point')
        //     ->group(function () {
        //         Route::get('/', [FarmersPointController::class, 'index']);
        //         Route::post('/', [FarmersPointController::class, 'store']);
        //         Route::get('/{farmers_point}', [FarmersPointController::class, 'show']);
        //         Route::put('/{farmers_point}', [FarmersPointController::class, 'update']);
        //         Route::delete('/{farmers_point}', [FarmersPointController::class, 'destroy']);
        //     });
        // // Route::prefix('distributor')
        // //     ->group(function () {

        // //         Route::post('/', [DistributorInfoController::class, 'store']);
        // //         Route::get('/{distributor}', [DistributorInfoController::class, 'show']);
        // //         Route::put('/{distributor}', [DistributorInfoController::class, 'update']);
        // //         Route::delete('/{distributor}', [DistributorInfoController::class, 'destroy']);
        // //     });
        // Route::prefix('farmer_deposit')
        //     ->group(function () {
        //         Route::get('/', [FarmerDepositController::class, 'index']);
        //         Route::post('/', [FarmerDepositController::class, 'store']);
        //         Route::get('/{farmer_deposit}', [FarmerDepositController::class, 'show']);
        //         Route::put('/{farmer_deposit}', [FarmerDepositController::class, 'update']);
        //         Route::delete('/{farmer_deposit}', [FarmerDepositController::class, 'destroy']);
        //     });
    });
