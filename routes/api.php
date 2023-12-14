<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ActivityController;
use App\Http\Controllers\Api\v1\AdvisoryController;
use App\Http\Controllers\Api\v1\AttendanceController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\BatchController;
use App\Http\Controllers\Api\v1\CashInRequestController;
use App\Http\Controllers\Api\v1\CashOutRequestController;
use App\Http\Controllers\Api\v1\ChannelController;
use App\Http\Controllers\Api\v1\DashboardController;
use App\Http\Controllers\Api\v1\DistributorsFileController;
use App\Http\Controllers\Api\v1\FarmerController;
use App\Http\Controllers\Api\v1\UnitController;
use App\Http\Controllers\Api\v1\UpazilaController;
use App\Http\Controllers\Api\v1\DistrictController;
use App\Http\Controllers\Api\v1\DivisionController;
use App\Http\Controllers\Api\v1\EmployeeController;
use App\Http\Controllers\Api\v1\FarmController;
use App\Http\Controllers\Api\v1\FarmerGroupController;
use App\Http\Controllers\Api\v1\FertilizationController;
use App\Http\Controllers\Api\v1\FinanceRequestController;
use App\Http\Controllers\Api\v1\InputOrderController;
use App\Http\Controllers\Api\v1\LandPreparationController;
use App\Http\Controllers\Api\v1\LogisticController;
use App\Http\Controllers\Api\v1\OrdersController;
use App\Http\Controllers\Api\v1\OutputCustomerController;
use App\Http\Controllers\Api\v1\PesticideController;
use App\Http\Controllers\Api\v1\ProductCategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\ProductSubCategoryController;
use App\Http\Controllers\Api\v1\SourceSellingController;
use App\Http\Controllers\Api\v1\SourcingController;
use App\Http\Controllers\Api\v1\SowingController;
use App\Http\Controllers\Api\v1\SurveyController;
use App\Http\Controllers\Api\v1\TransactionController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\WateringController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::prefix('v1/')
    ->middleware(['cors'])
    ->group(function () {

        Route::post('hq/login', [AuthController::class, 'login'])->name('hq_login');
        Route::post('co/login', [AuthController::class, 'login'])->name('co_login');
        Route::post('distributor/login', [AuthController::class, 'login'])->name('distributor_login');
        Route::post('me/login', [AuthController::class, 'login'])->name('me_login');
        Route::post('pm/login', [AuthController::class, 'login'])->name('pm_login');
        Route::post('fp/login', [AuthController::class, 'login'])->name('fp_login');

        Route::group(['middleware' => ['auth:sanctum', 'user-access:HQ|ME|DB']], function () {
            Route::post('user/{user}/update', [UserController::class, 'update'])->name('user.update');
        });

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('division', [DivisionController::class, 'index']);
            Route::get('division/{division}', [DivisionController::class, 'show']);
            Route::get('district', [DistrictController::class, 'index']);
            Route::get('upazila', [UpazilaController::class, 'index']);
            // Route::get('upazila', [UpazilaController::class, 'index']);
            Route::get('unit', [UnitController::class, 'index']);
            Route::post('unit', [UnitController::class, 'store']);

            Route::get('all_category', [ProductCategoryController::class, 'index']);
            Route::get('sub_category', [ProductSubCategoryController::class, 'index']);
            Route::Post('sub_category', [ProductSubCategoryController::class, 'store']);
            Route::get('all_product', [ProductController::class, 'sort']);
            Route::get('product/sort', [ProductController::class, 'sort']);

            Route::get('product/{product}', [ProductController::class, 'show']);
            Route::get('all_company', [UserController::class, 'allCompany'])->name('all_company');

            Route::get('todays_attendance', [AttendanceController::class, 'todays_attendance'])->name('todays_attendance');
            Route::get('attendance_history', [AttendanceController::class, 'attendance_history'])->name('attendance_history');
            Route::get('attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
            Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
            Route::post('attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
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
                    Route::get('all_tm', [UserController::class, 'allTerritoryManager'])->name('all_tm');
                    Route::get('all_fp', [UserController::class, 'allFinancePartner'])->name('all_fp');
                    Route::get('all_farmer', [FarmerController::class, 'index']);
                    Route::get('farmer_search', [FarmerController::class, 'paginateFarmerWithSearch'])->name('paginateFarmerWithSearch');
                    Route::get('unassigned_distributor', [UserController::class, 'unassignedDistributor'])->name('unassigned_distributor');
                    Route::get('unassigned_me', [UserController::class, 'unassignedMe'])->name('unassigned_me');
                    Route::get('all_channel', [ChannelController::class, 'index'])->name('hq.all_channel');
                    Route::get('unassigned_channel', [ChannelController::class, 'unAssignChannel'])->name('hq.unassign_channel');
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
                    Route::post('product/{product}', [ProductController::class, 'update'])->name('hq.product_update');

                    Route::get('all_cash_out_request', [CashOutRequestController::class, 'index'])->name('hq.all_cash_out_request');
                    Route::put('cash_out_request/{cashOutRequest}', [CashOutRequestController::class, 'update'])->name('hq.cash_out_request_update');
                    Route::get('all_transaction', [TransactionController::class, 'index'])->name('hq.all_transaction');
                    Route::post('assign_channel/{employee}', [EmployeeController::class, 'assignChannel'])->name('hq.assign_channel');
                    Route::get('channel_list/{employee}', [EmployeeController::class, 'channelList'])->name('hq.channel_list');

                    Route::get('farmer_group', [FarmerGroupController::class, 'index'])->name('farmer_group');
                    Route::get('farmer_group/{farmer_group}', [FarmerGroupController::class, 'show'])->name('farmer_group.show');

                    Route::get('all_farm', [FarmController::class, 'index'])->name('hq.all_farm');
                    Route::get('farm/{farm}', [FarmController::class, 'show'])->name('hq.farm.show');
                    Route::get('farmer_farm/{farmer}', [FarmController::class, 'farmer_farm'])->name('hq.farmer_farm');

                    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
                    Route::get('advisory', [AdvisoryController::class, 'index'])->name('advisory');

                    Route::get('batch', [BatchController::class, 'index'])->name('hq.batch');
                    Route::get('batch/{batch}', [BatchController::class, 'show'])->name('hq.batch.show');
                    Route::get('farm_batch', [BatchController::class, 'farmBatch'])->name('hq.farmBatch');
                    Route::get('logistic', [LogisticController::class, 'index'])->name('logistic');

                    Route::post('sourcing', [SourcingController::class, 'store'])->name('hq.sourcing.store');

                    Route::get('output_customer', [OutputCustomerController::class, 'index'])->name('output_customer');

                    Route::get('sourcing', [SourcingController::class, 'index'])->name('hq.sourcing');
                    Route::get('sourcing/{sourcing}', [SourcingController::class, 'show'])->name('hq.sourcing.show');
                    Route::get('source_selling', [SourceSellingController::class, 'index'])->name('hq.source_selling.index');
                    Route::post('source_selling', [SourceSellingController::class, 'store'])->name('hq.source_selling.store');
                    Route::get('source_selling/{source_selling}', [SourceSellingController::class, 'show'])->name('hq.source_selling.show');
                    Route::get('day_wise_source_selling', [SourceSellingController::class, 'dayWiseSourceSelling'])->name('dayWiseSourceSelling');
                    Route::get('testForSourceSellingDataExport', [DashboardController::class, 'testForSourceSellingDataExport']);

                    Route::get('farmer_source_selling/{farmer}', [FarmerController::class, 'farmer_source_selling']);

                    Route::get('finance_request', [FinanceRequestController::class, 'index']);
                    Route::get('finance_request/{request_finance}', [FinanceRequestController::class, 'show']);
                    Route::post('finance_request/{request_finance}', [FinanceRequestController::class, 'update']);

                    Route::prefix('dashboard/')->group(
                        function () {
                            Route::get('all_member', [DashboardController::class, 'all_member'])->name('hq.all_member');
                            Route::get('total_group', [DashboardController::class, 'total_group'])->name('total_group');
                            Route::get('location_wise_farmer', [DashboardController::class, 'location_wise_farmer'])->name('district_wise_farmer');
                            Route::get('male_female', [DashboardController::class, 'location_wise_Male_Female'])->name('male_female');
                            Route::get('map', [DashboardController::class, 'map'])->name('map');
                            Route::get('ssstat', [DashboardController::class, 'sourceAndSourceSellingStat'])->name('ssstat');
                            Route::get('ssstatm', [DashboardController::class, 'ourceAndSourceSellingStatMonth'])->name('ssstatm');
                            Route::get('sourcingUnitWiseQuantity', [DashboardController::class, 'sourcingUnitWiseQuantity'])->name('sourcingUnitWiseQuantity');
                        }
                    );
                });
        });

        Route::group(['middleware' => ['auth:sanctum', 'user-access:CO|HQ']], function () {
            Route::post('add_product', [ProductController::class, 'store'])->name('add_product');
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
                    Route::get('my_profile', [EmployeeController::class, 'myProfile'])->name('db.my_profile');
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
                    Route::post('create_group', [FarmerGroupController::class, 'store'])->name('me.create_group');
                    Route::get('group/{farmer_group}', [FarmerGroupController::class, 'show'])->name('group.show');
                    Route::get('group', [FarmerGroupController::class, 'myGroup'])->name('me.my_group');
                    Route::get('free_group', [FarmerGroupController::class, 'freeGroup'])->name('me.free_group');
                    Route::get('unassign_farmer', [FarmerController::class, 'unassignedFarmer'])->name('me.unassign_farmer');
                    Route::put('farmer_group/{farmer_group}', [FarmerGroupController::class, 'update'])->name('farmer_group.update');
                    Route::post('farmer_group/{farmer_group}/assign', [FarmerGroupController::class, 'assignFarmer'])->name('farmer_group.assignFarmer');

                    Route::post('survey', [SurveyController::class, 'store'])->name('me.survey.store');
                    Route::post('my_farmer/{farmer}', [FarmerController::class, 'update'])->name('me.farmer.update');

                    Route::post('advisory', [AdvisoryController::class, 'store'])->name('advisory.store');
                    Route::get('farmer_farm/{farmer}', [FarmController::class, 'farmer_farm'])->name('farmer_farm');
                    Route::post('activity', [ActivityController::class, 'store'])->name('activity.store');
                    Route::get('my_activity', [ActivityController::class, 'myRecordedActivities'])->name('myRecordedActivities');

                    Route::get('popular_product', [ProductController::class, 'popular_product'])->name('popular_product');
                    Route::get('farmer_search', [FarmerController::class, 'MepaginateFarmerWithSearch'])->name('MepaginateFarmerWithSearch');

                    Route::post('batch', [BatchController::class, 'store'])->name('batch.store');
                    Route::get('farm_batch', [BatchController::class, 'farmBatch'])->name('farmBatch');
                    Route::get('my_batch', [BatchController::class, 'my_batch'])->name('me.my_batch');
                    Route::get('batch/{batch}', [BatchController::class, 'show'])->name('me.batch.show');

                    Route::post('logistic', [LogisticController::class, 'store'])->name('logistic.store');

                    Route::post('sourcing', [SourcingController::class, 'store'])->name('sourcing.store');
                    Route::get('my_sourcing', [SourcingController::class, 'mySourcing'])->name('me.my_sourcing');
                    Route::get('sourcing/{sourcing}', [SourcingController::class, 'show'])->name('me.sourcing.show');

                    Route::post('land_preparation', [LandPreparationController::class, 'store'])->name('land_preparation.store');
                    Route::post('sowing', [SowingController::class, 'store'])->name('sowing.store');
                    Route::post('fertilization', [FertilizationController::class, 'store'])->name('fertilization.store');
                    Route::post('watering', [WateringController::class, 'store'])->name('watering.store');
                    Route::post('pesticide', [PesticideController::class, 'store'])->name('pesticide.store');
                    Route::post('finance_request', [FinanceRequestController::class, 'store'])->name('store.finance_request');
                });
        });

        // route for HeadQuatre and Company
        Route::group(['middleware' => ['auth:sanctum', 'user-access:HQ_MAN']], function () {
            Route::prefix('manager/dashboard')
                ->group(function () {
                    Route::get('company_wise_product', [DashboardController::class, 'company_wise_product'])->name('company_wise_product');
                    Route::get('all_member', [DashboardController::class, 'all_member'])->name('all_count');
                    Route::get('total_group', [DashboardController::class, 'total_group'])->name('manager.total_group');
                    Route::get('farmer_added', [DashboardController::class, 'farmer_added'])->name('farmer_added');
                    Route::get('location_wise_farmer', [DashboardController::class, 'location_wise_farmer'])->name('manager.location_wise_farmer');
                    Route::get('cp_wise_farmer', [DashboardController::class, 'distributor_wise_farmer'])->name('distributor_wise_farmer');
                });
        });

        Route::get('test', [DashboardController::class, 'test'])->name('test');
        Route::get('test2', [DashboardController::class, 'farmerOnboard TimeWithCount'])->name('farmerOnboardTimeWithCount');
        Route::get('phone_error', [DashboardController::class, 'phone_error'])->name('phone_error');
        Route::get('group_leaders', [DashboardController::class, 'groupLeadersName'])->name('phone_error2');

        Route::get('dob_error', [DashboardController::class, 'dob_error'])->name('dob_error');

        //
        // Route::get('advisory/{advisory}',[AdvisoryController::class,'show'])->name('advisory.show');
        //
        // Route::put('advisory/{advisory}',[AdvisoryController::class,'update'])->name('advisory.update');
        // Route::delete('advisory/{advisory}',[AdvisoryController::class,'destroy'])->name('advisory.destroy');

        // Route::get('activity',[ActivityController::class,'index'])->name('activity');
        // Route::get('activity/{activity}',[ActivityController::class,'show'])->name('activity.show');
        // Route::put('activity/{activity}',[ActivityController::class,'update'])->name('activity.update');
        // Route::delete('activity/{activity}',[ActivityController::class,'destroy'])->name('activity.destroy');
        // Route::get('public_farmer_trace/{farmer}', [FarmerController::class, 'publicFarmerTrace'])->name('public_farmer_trace');
        // Route::put('sourcing/{sourcing}', [SourcingController::class, 'update'])->name('sourcing.update');
        // Route::delete('sourcing/{sourcing}', [SourcingController::class, 'destroy'])->name('sourcing.destroy');
        // Route::get('land_preparation', [LandPreparationController::class, 'index'])->name('land_preparation');
        // Route::get('land_preparation/{land_preparation}', [LandPreparationController::class, 'show'])->name('land_preparation.show');

        // Route::get('farmerWithoutUSAIDAtJessore',[DashboardController::class , 'farmerWithoutUSAIDAtJessore'])->name('farmerWithoutUSAIDAtJessore');
        // route for HeadQuatre and Company

        Route::group(['middleware' => ['auth:sanctum', 'user-access:FP']], function () {
            Route::prefix('fp/dashboard')
                ->group(function () {
                    // Route::get('all_request',[FinanceRequestController::class])

                });
        });


    });
