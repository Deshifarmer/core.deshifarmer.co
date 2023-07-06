<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CashInRequestController;
use App\Http\Controllers\Api\v1\CashOutRequestController;
use App\Http\Controllers\Api\v1\ChannelController;
use App\Http\Controllers\Api\v1\ClusterController;
use App\Http\Controllers\Api\v1\DistributorsFileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\FarmerController;
use App\Http\Controllers\Api\v1\UnitController;
use App\Http\Controllers\Api\v1\UpazilaController;
use App\Http\Controllers\Api\v1\DistrictController;
use App\Http\Controllers\Api\v1\DivisionController;
use App\Http\Controllers\Api\v1\EmployeeController;
use App\Http\Controllers\Api\v1\FarmController;
use App\Http\Controllers\Api\v1\FarmerGroupController;
use App\Http\Controllers\Api\v1\InputOrderController;
use App\Http\Controllers\Api\v1\OrdersController;
use App\Http\Controllers\Api\v1\ProductCategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\ProductSubCategoryController;
use App\Http\Controllers\Api\v1\TransactionController;
use App\Http\Controllers\Api\v1\UserController;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

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

        // Route::get('farm',[FarmController::class,'index'])->name('farm');
        // Route::get('farm/{farm}',[FarmController::class,'show'])->name('farm.show');
        // Route::post('farm',[FarmController::class,'store'])->name('farm.store');
        // Route::put('farm/{farm}',[FarmController::class,'update'])->name('farm.update');
        // Route::delete('farm/{farm}',[FarmController::class,'destroy'])->name('farm.destroy');

        // Route::get('cluster',[ClusterController::class,'index'])->name('cluster');
        // Route::get('cluster/{cluster}',[ClusterController::class,'show'])->name('cluster.show');
        // Route::post('cluster',[ClusterController::class,'store'])->name('cluster.store');
        // Route::put('cluster/{cluster}',[ClusterController::class,'update'])->name('cluster.update');
        // Route::delete('cluster/{cluster}',[ClusterController::class,'destroy'])->name('cluster.destroy');

        // Route::get('farmer_group',[FarmerGroupController::class,'index'])->name('farmer_group');
        // Route::get('farmer_group/{farmer_group}',[FarmerGroupController::class,'show'])->name('farmer_group.show');
        //
        // Route::put('farmer_group/{farmer_group}',[FarmerGroupController::class,'update'])->name('farmer_group.update');
        // Route::delete('farmer_group/{farmer_group}',[FarmerGroupController::class,'destroy'])->name('farmer_group.destroy');

        Route::post('hq/login', [AuthController::class, 'login'])->name('hq_login');
        Route::post('co/login', [AuthController::class, 'login'])->name('co_login');
        Route::post('distributor/login', [AuthController::class, 'login'])->name('distributor_login');
        Route::post('me/login', [AuthController::class, 'login'])->name('me_login');

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
            Route::get('all_product', [ProductController::class, 'sort']);
            Route::get('product/sort', [ProductController::class, 'sort']);

            Route::get('product/{product}', [ProductController::class, 'show']);
            Route::get('all_company', [UserController::class, 'allCompany'])->name('all_company');


            //test routes

            //end test routes

        });


        //all route only for HeadQuatre
        Route::group(['middleware' => ['auth:sanctum', 'user-access:HQ']], function () {
            Route::prefix('hq/')
                ->group(function () {
                    Route::post('add', [AuthController::class, 'register'])->name('add_hq_co_dis_me');
                    Route::get('all_distributor', [UserController::class, 'allDistributor'])->name('all_distributor');
                    Route::post('distributor_file', [DistributorsFileController::class, 'store']);
                    Route::get('distributor_file/{distributors_file}', [DistributorsFileController::class, 'show']);
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
                    Route::get('all_product', [ProductController::class, 'index'])->name('hq.all_product');
                    Route::put('product/{product}', [ProductController::class, 'update'])->name('hq.product_update');
                    Route::get('all_cash_out_request', [CashOutRequestController::class, 'index'])->name('hq.all_cash_out_request');
                    Route::put('cash_out_request/{cashOutRequest}', [CashOutRequestController::class, 'update'])->name('hq.cash_out_request_update');
                    Route::get('all_transaction', [TransactionController::class, 'index'])->name('hq.all_transaction');
                });
        });

        //all route only for Company
        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO']], function () {
            Route::prefix('co/')
                ->group(function () {
                    Route::get('my_product', [ProductController::class, 'companyWiseProduct'])->name('companyWiseProduct');
                    Route::get('my_new_order', [OrdersController::class, 'company_new_order'])->name('co.my_new_order');
                    Route::get('my_confirm_order', [OrdersController::class, 'company_confirm_order'])->name('co.my_confirm_order');
                    Route::get('my_delivery_history', [OrdersController::class, 'company_delivery_history'])->name('co.delivery_history');
                    Route::put('my_order/{order}', [OrdersController::class, 'update'])->name('co.order_update');
                    Route::get('order/{order}', [OrdersController::class, 'show'])->name('co.single_order');
                    Route::post('cash_out_request', [CashOutRequestController::class, 'store'])->name('co.cash_out_request');
                    Route::get('my_profile', [EmployeeController::class, 'myProfile'])->name('co.my_profile');
                    Route::get('all_transaction', [TransactionController::class, 'myTransactions'])->name('co.all_transaction');
                });
        });

        //all route only for Distributor
        Route::prefix('distributor')
            ->group(function () {
                Route::group(['middleware' => ['auth:sanctum', 'user-access:DB']], function () {
                    Route::get('my_profile', [EmployeeController::class, 'myProfile'])->name('my_profile');
                    Route::get('my_me', [EmployeeController::class, 'myMe'])->name('distributor.my_me');
                    Route::get('my_me/{employee}/profile', [EmployeeController::class, 'myMeProfile'])->name('distributor.my_me_profile');
                    Route::get('me_collection', [InputOrderController::class, 'meCollection'])->name('distributor.me_collection');
                    Route::get('me_new_order', [InputOrderController::class, 'meNewOrder'])->name('distributor.me_new_order');
                    Route::get('me_confirm_order_status', [InputOrderController::class, 'meConfirmOrderStatus'])->name('distributor.me_confirm_order_status');
                    Route::get('me_order/{input_order}', [InputOrderController::class, 'input_order_details'])->name('dis.input_order_details');
                    Route::post('cash_in_request/', [CashInRequestController::class, 'store'])->name('dis.cash_in_request');
                    Route::post('cash_out_request', [CashOutRequestController::class, 'store'])->name('dis.cash_out_request');
                    Route::get('my_cash_out_request', [CashOutRequestController::class, 'myCashOutRequests'])->name('dis.my_cash_out_request');
                    Route::get('my_cash_in_request/', [CashInRequestController::class, 'myCashInReq'])->name('dis.my_cash_in_request');
                    Route::put('me_order/{input_order}', [InputOrderController::class, 'update'])->name('dis.input_order_update');
                    Route::get('collect_order', [OrdersController::class, 'disCollectOrder'])->name('dis.collectOrder');
                    Route::put('collect_product/{order}', [OrdersController::class, 'update'])->name('dis.order_update');
                    Route::get('order_history', [InputOrderController::class, 'disOrderHistory'])->name('dis.order_history');
                    Route::get('all_transaction', [TransactionController::class, 'myTransactions'])->name('db.all_transaction');
                });
            });


        //all route only for Micro Entrepreneur
        Route::group(['middleware' => ['auth:sanctum', 'user-access:ME']], function () {
            Route::prefix('me/')
                ->group(function () {
                    Route::get('my_profile', [EmployeeController::class, 'myProfile'])->name('me.my_profile');
                    Route::post('add_farmer', [FarmerController::class, 'store'])->name('me.add_farmer');
                    Route::get('my_farmer', [FarmerController::class, 'myFarmer'])->name('me.my_farmer');
                    Route::get('my_farmer/{farmer}', [FarmerController::class, 'show'])->name('me.my_single_farmer');
                    Route::post('input_order', [InputOrderController::class, 'store'])->name('me.input_order.store');
                    Route::get('order', [InputOrderController::class, 'myOrder'])->name('me.me_order');
                    Route::post('cash_out_request', [CashOutRequestController::class, 'store'])->name('me.cash_out_request');
                    Route::get('order/{input_order}', [InputOrderController::class, 'input_order_details'])->name('me.single_input_order');
                    Route::get('collect_order', [InputOrderController::class, 'collectOrder'])->name('me.collectOrder');
                    Route::put('collect_order/{input_order}', [InputOrderController::class, 'update'])->name('me.input_order_update');
                    Route::post('add_farm', [FarmController::class, 'store'])->name('farm.store');
                    Route::get('all_transaction', [TransactionController::class, 'myTransactions'])->name('me.all_transaction');
                    // Route::get('all_channel', [ChannelController::class, 'index'])->name('me.all_channel');
                    // Route::post('add_cluster',[ClusterController::class,'store'])->name('me.cluster.store');
                });
        });

        // route for HeadQuatre and Company
        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO|HQ']], function () {
            Route::post('add_product', [ProductController::class, 'store'])->name('add_product');
        });
    });
