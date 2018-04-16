<?php

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

// Webhook
//Route::group(['namespace' => 'Webhook', 'prefix' => 'webhook'], function () {
//    Route::post('stripe', 'StripeController@handleWebhook')->name('webhook.stripe');
//});

// Authentication Routes...
Auth::routes();

// Activation account
Route::get('/activate', 'Auth\ActivateController@handle')->name('activate');

// Facebook connect
Route::get('/connecting/{network}', 'Auth\SocialAuthController@redirect');
Route::get('/connected/{network}', 'Auth\SocialAuthController@callback');
Route::get('revoke/{id}/facebook', 'Auth\SocialAuthController@revokeUser');
Route::get('/revoke/{network}', 'Auth\SocialAuthController@revoke');
/**
 * Permission routes
 */
Route::group(['namespace' => 'Permissions'], function () {
	Route::resource('set-permissions', 'UsersController', ['only' => ['index', 'edit', 'update']]);
	Route::resource('permissions', 'PermissionsController', ['only' => ['index', 'edit', 'update']]);
	Route::resource('roles', 'RolesController');
});

// Upgrade account
//Route::post('upgrade/creator', 'UsersController@upgradeCreator');
Route::get('/upgrade/{role}', 'UsersController@upgradeAccount')->name('upgrade-account');

// Update profile
Route::get('/profile/{tab?}', 'UsersController@updateProfile')->name('update-profile');
Route::post('/profile/{tab?}', 'UsersController@update')->name('users.update');

// Subscriptions
Route::get('/plans', 'SubscriptionsController@index')->name('pricing');
Route::get('/plans/{planId}', 'SubscriptionsController@show')->name('subscriptions.show');
Route::post('/subscribe', 'SubscriptionsController@subscribe')->name('subscriptions.subscribe');

// Prime project
Route::get('/prime-projects/desc', 'PrimeProjectsController@desc');
Route::get('/prime-projects/facebook-cert', 'PrimeProjectsController@facebookCert')->name('facebook.cert');

Route::get('/prime-projects/facebook-report', 'PrimeProjectsController@facebookReport')->name('analyze.index');
Route::get('/prime-projects/facebook/{adAccountId}/campaigns', 'PrimeProjectsController@facebookListCampaigns')->where('adAccountId', '^act_\\d+$');
Route::get('/prime-projects/facebook/{campaignId}/insights', 'PrimeProjectsController@facebookGetInsights')->where('campaignId', '^\\d+$');
Route::get('prime-projects/{id}/proposals', 'PrimeProjectsController@showProposals')->name('prime_projects.proposals');

Route::get('/prime-projects/facebook-alert', 'PrimeProjectsController@facebookAlert')->name('alerts.index');
Route::post('/prime-projects/facebook-alert', 'PrimeProjectsController@saveJob')->name('alerts.store');
Route::delete('/prime-projects/facebook-alert/{id}', 'PrimeProjectsController@deleteJob')->name('alerts.delete');
Route::post('prime-projects/{id}/accept-proposals', 'PrimeProjectsController@acceptProposals')->name('prime-projects.accept-proposals');
Route::resource('prime-projects', 'PrimeProjectsController');

// Projects
Route::post('projects/estimate/{id}', 'ProjectsController@updateEstimate')->name('projects.estimate');
Route::get('projects/admin', 'ProjectsController@indexAdmin');
Route::get('projects/joined', 'ProjectsController@joined');
Route::get('projects/invoice/{id}', 'ProjectsController@downloadPDF')->name('download.invoice');
Route::post('projects/admin/filter', 'ProjectsController@adminFilter');
Route::post('/projects/pay', 'ProjectsController@pay')->name('projects.pay');
Route::post('/projects/finish', 'ProjectsController@fixedPrice');
Route::get('/projects/finish/{id}', 'ProjectsController@finish')->name('projects.finish');
Route::get('/projects/client', 'ProjectsController@indexClient')->name('projects.client');
Route::post('/projects/status/{id}', 'ProjectsController@status');
Route::put('projects/{id}/simple-update', 'ProjectsController@simpleUpdate')->name('projects.simple');
Route::resource('projects', 'ProjectsController');
// Route::get('projects-state/list', 'ProjectStateController@list');
// Route::post('projects-state/filter', 'ProjectStateController@filtering');
Route::post('project-states/acceptance', 'ProjectStateController@acceptance');
Route::resource('project-states', 'ProjectStateController');

Route::post('creative-rooms/add', 'CreativeRoomsController@createAjax');
Route::post('creative-rooms/token', 'CreativeRoomsController@getLink');
Route::get('creative-rooms/{id}/invitation/{token}', 'CreativeRoomsController@accept')->name('rooms.accept');
Route::post('creative-rooms/accept', 'CreativeRoomsController@masterAccept');
Route::post('creative-rooms/update-label', 'CreativeRoomsController@updateLabel');
Route::get('creative-rooms/{id}/member', 'CreativeRoomsController@getMember');
Route::post('creative-rooms/ajax-store', 'CreativeRoomsController@ajaxStore');
Route::delete('creative-rooms/delete/{id}', 'CreativeRoomsController@destroy')->name('rooms.delete');
Route::delete('creative-rooms/{id}', 'CreativeRoomsController@removeUser')->name('rooms.remove-user');
Route::get('creative-rooms/upload', 'CreativeRoomsController@testUploadFile');
Route::post('messages/box', 'MessageBoxController@getChatDialog');
Route::post('messages/paginate', 'MessagePaginationController@messages')->name('messages.paginate');
Route::post('messages/crluo', 'MessagePaginationController@crluoMessages');
Route::resource('creative-rooms', 'CreativeRoomsController');

Route::post('creative-rooms/downloadfile', 'CreativeRoomsController@downloadFile');
Route::get('creative-rooms-downloadfile', 'CreativeRoomsController@getfile');

Route::get('c-operation/proposals', 'ProposalsController@operationIndex');
Route::get('c-operation/acceptance/{id}', 'ProposalsController@operationAcceptance')->name('operation.acceptance');
Route::get('c-operation/client-acceptance/{id}', 'ProposalsController@clientOperationAcceptance')->name('operation.client_acceptance');
Route::get('c-operation/admin-acceptance/{id}', 'ProposalsController@adminOperationAcceptance')->name('operation.admin_acceptance');
Route::put('proposals/acceptance', 'ProposalsController@creatorAcceptance')->name('proposals.acceptance');
Route::get('proposals/list', 'ProposalsController@list');
route::get('proposals/list/{id}', 'ProposalsController@ownerList');
Route::resource('proposals', 'ProposalsController');

Route::get('portfolios/me', 'PortfoliosController@me')->name('portfolios.me');
Route::post('portfolios/price-filter', 'PortfoliosController@filterPrice');
Route::post('portfolio/{id}/scope', 'PortfoliosController@scope');
Route::post('portfoliossort', 'PortfoliosController@portfoliossort');
Route::resource('portfolios', 'PortfoliosController');
Route::resource('creators', 'CreatorsController');

Route::get('messages/reload', 'MessagesController@reloadMessage');
Route::get('messages/creload', 'MessagesController@reloadCrluoMessage');
Route::get('messages/box', 'MessageBoxController@getChatDialog');
Route::resource('rewords', 'RewordController');
Route::resource('payments', 'PaymentsController');
Route::resource('messages', 'MessageBoxController');

// News/Info
Route::get('notifications/get', 'NotificationController@list');
Route::get('notifications/read-all', 'NotificationController@markAllReaded')->name('notifications.mark');
Route::get('notifications/mark', 'NotificationController@markAsReaded');
Route::resource('notifications', 'NotificationController');
Route::get('broadcast', 'BroadcastController@index')->name('broadcast.index');
Route::post('broadcast', 'BroadcastController@send')->name('broadcast.send');

Route::post('proposal-messages/create', 'ProposalMessageController@create');
Route::post('proposal-messages', 'ProposalMessageController@store');

Route::post('s3', 'S3UploaderController@endpoint');
Route::post('s3/success', 'S3UploaderController@success');
Route::delete('s3/delete/{uuid}', 'S3UploaderController@deleteEndpoint');

Route::post('messages/send', 'MessagesController@store');
Route::post('messages/reload', 'MessagesController@reloadMessage');
Route::get('files/{id}/download', 'FileController@download')->name('files.download');
Route::post('files/upload/{type}', 'FileController@store');
Route::get('files/preview/{id}', 'FileController@previewFiles');
Route::get('files/projects/{id}', 'FileController@workFiles')->name('files.project');
Route::get('files/captions', 'FileController@getCaptions');
Route::post('/tasks/update', 'FileController@updateState');
Route::delete('files/{id}', 'FileController@destroy');
Route::post('creative-rooms/add-member', 'CreativeRoomsController@addMember');
Route::delete('previews/{id}', 'CreativeroomPreviewController@destroy');
Route::post('previews', 'CreativeroomPreviewController@store');
Route::get('videos/{id}', 'FileController@stream');
Route::post('creators/filter', 'CreatorsController@list');
Route::post('creators/active', 'CreatorsController@active');
Route::post('portfolios/filter', 'PortfoliosController@list');
Route::post('contacts/preview', 'ContactController@preview');
Route::post('contacts', 'ContactController@sendMail');
Route::get('contacts', 'ContactController@index');
Route::post('users/change-email', 'UsersController@changeEmail')->name('users.email');
Route::get('users/{id}', 'UsersController@show')->name('users.show');
Route::post('users/filter', 'UsersController@list');
Route::post('messages/filter', 'MessageBoxController@list');
Route::post('documents/filter', 'DocumentController@list');
Route::post('documents', 'DocumentController@store');
Route::delete('documents/{id}', 'DocumentController@destroy');
Route::resource('admin/user', 'UserManagementController', ['names' => 'admin.user']);

// Admin payments management
Route::get('admin/payments/{userId}', 'AdminPaymentController@index')->name('admin.payments.index');
Route::get('admin/payments/{userId}/create', 'AdminPaymentController@create')->name('admin.payments.create');
Route::post('admin/payments/{userId}', 'AdminPaymentController@store')->name('admin.payments.store');
Route::get('admin/payments/{userId}/{id}/edit', 'AdminPaymentController@edit')->name('admin.payments.edit');
Route::put('admin/payments/{id}', 'AdminPaymentController@update')->name('admin.payments.update');

// Admin reword management
Route::get('admin/rewords/{userId}', 'AdminRewordController@index')->name('admin.rewords.index');
Route::get('admin/rewords/{userId}/create', 'AdminRewordController@create')->name('admin.rewords.create');
Route::post('admin/rewords/{userId}', 'AdminRewordController@store')->name('admin.rewords.store');
Route::get('admin/rewords/{id}/edit', 'AdminRewordController@edit')->name('admin.rewords.edit');
Route::put('admin/rewords/{id}', 'AdminRewordController@update')->name('admin.rewords.update');

Route::resource('admin/c-operation', 'AdminSubscriptionController', ['names' => 'admin.c_operation']);

// top page
Route::get('/', 'HomeController@index')->name('home');
Route::get('/switch', 'HomeController@switchMode');
//Route::get('/pf', 'WelcomeController@portfolio');
Route::get('/pf', 'WelcomeController@pf');
Route::get('/pr', 'WelcomeController@pr');
Route::get('/fc', 'WelcomeController@forcreator');
Route::get('/ab', 'WelcomeController@about');
Route::get('/atv', 'WelcomeController@atv');
Route::get('/intro', 'WelcomeController@intro');
Route::get('/marketing', 'WelcomeController@marketing');
Route::get('/qa', 'WelcomeController@qa');

Route::get('/about', 'WelcomeController@about');
Route::get('/use', 'WelcomeController@flow');
Route::get('/company', 'WelcomeController@company');
Route::get('/rules', 'WelcomeController@rules');
Route::get('/policy', 'WelcomeController@policy');
Route::get('/privacy', 'WelcomeController@privacy');

// Document Download
Route::any('/download/request', 'WelcomeController@request');
Route::any('/download/{id}', 'WelcomeController@download');

// Guest Preview
Route::any('/guest/url/{id}', 'WelcomeController@guestUrl');
Route::get('/guest/preview/{id}', 'WelcomeController@guestPreview');
Route::get('/guest/movie/{id}', 'WelcomeController@guestMovie');

// shared company info
Route::resource('companyinfo', 'CompanyInfoController');

// home
// Route::get('/home', 'HomeController@index')->name('home');
Route::any('/user/update', 'HomeController@userupdate');
//Route::any('/profile/{id?}', 'HomeController@profile');
Route::any('/portfolio', 'HomeController@portfolio');
Route::any('/project/{mode?}', 'HomeController@project');
Route::any('/compe/{mode?}{id?}', 'HomeController@compe');
Route::any('/message', 'HomeController@message');
Route::any('/chat', 'HomeController@chat');
Route::any('/creator', 'HomeController@creator');
Route::any('/work', 'HomeController@work');
// Route::any('/reword', 'HomeController@reword');
Route::any('/entry', 'HomeController@entry');
Route::get('/help', 'HomeController@help');
Route::get('/nda', 'HomeController@nda');

// admin
Route::get('/admin/users', 'AdminController@index')->name('admin');
Route::post('/admin/users', 'AdminController@index');
Route::resource('admin/projects', 'AdminProjectController', ['names' => 'admin.projects']);
Route::get('admin/approval', 'ProjectApprovalController@index')->name('approval');
Route::get('admin/rooms', 'AdminController@roomList')->name('admin.rooms');
Route::get('admin/rooms/{id}', 'AdminController@showRoom')->name('admin.rooms.show');
Route::get('approvals/{id}/edit', 'ProjectApprovalController@edit')->name('approvals.edit');
Route::put('approvals/{id}', 'ProjectApprovalController@update')->name('approvals.update');
Route::get('/admin/messages', 'AdminController@messages')->name('admin.messages');
Route::any('/admin/home', 'AdminController@anyHome');
Route::any('/admin/message/{mode?}', 'AdminController@anyMessage');
Route::any('/admin/project/{mode?}/{id?}', 'AdminController@anyProject');
Route::any('/admin/portfolio/{mode}', 'AdminController@anyPortfolio');
Route::any('/admin/up', 'AdminController@anyUp');
Route::any('/admin/delete', 'AdminController@anyDelete');
Route::any('/admin/file/{id}', 'AdminController@anyFile');
Route::post('/admin/document', 'AdminController@postDocument');

// ajax
Route::any('/ajax/unseencount/{kind}', 'AjaxController@anyUnseencount')->name('unseencount');
Route::any('/ajax/info/{kind}/{id?}', 'AjaxController@anyInfo')->name('info');
Route::any('/ajax/message/{kind}/{id?}', 'AjaxController@anyMessage')->name('message');
Route::any('/ajax/readed/{messageid}', 'AjaxController@anyReaded')->name('readed');
Route::any('/ajax/send', 'AjaxController@anySend')->name('send');
Route::any('/ajax/sort', 'AjaxController@anySort')->name('sort');
Route::any('/ajax/mail/{kind}/{id?}', 'AjaxController@anyMail')->name('mail');
Route::any('/ajax/work/{mode}', 'AjaxController@anyWork')->name('work');
Route::any('/ajax/user/{mode}/{id?}', 'AjaxController@anyUser')->name('user');
Route::any('/ajax/project/{mode}/{id?}', 'AjaxController@anyProject')->name('project');
Route::any('/ajax/compe/{mode}/{id?}/{user_id?}', 'AjaxController@anyCompe')->name('compe');
Route::any('/ajax/reword/{mode}/{id?}/{user_id?}', 'AjaxController@anyReword')->name('reword');
Route::any('/ajax/preview/{mode?}', 'AjaxController@anyPreview')->name('preview');
Route::any('/ajax/portfolio/{mode}/{id?}', 'AjaxController@anyPortfolio')->name('portfolio');

Route::get('/coperation', 'ProjectsController@coperation');
Route::get('/senemailcoperation', 'ProjectsController@sendEmailCoperation');


Route::get('/updatetypemovie', 'ProjectsController@updateProjectMovieType');
Route::get('/updatestypemovie', 'ProjectsController@updateProjectMovieStype');
Route::get('/updateportfoliostypemovie', 'ProjectsController@updatePortfolioStyles');

Route::get('/updateportfoliotypemovie', 'ProjectsController@updatePortfolioTypes');

