<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/add-newsletter', 'Home::addNewsletter');
$routes->get('/search', 'ProductController::search');
$routes->get('/about-us', 'Pages::page/about');
$routes->get('/contact-us', 'Pages::page/contact');
$routes->get('/faq', 'Pages::page/faq');
$routes->get('/privacy-policy', 'Pages::page/privacy');
$routes->get('/terms-and-conditions', 'Pages::page/terms');
$routes->get('/privacy-policy', 'Pages::page/privacy');
$routes->get('/videos', 'Pages::page/videos');
$routes->get('/blog', 'Blog::index');
$routes->get('/blog/(:segment)', 'Blog::view/$1');
$routes->get('/blog/category/(:segment)', 'Blog::category/$1');
$routes->get('/blog/categories', 'Blog::categories');
$routes->get('/products', 'ProductController::index');
$routes->get('/product/(:segment)', 'ProductController::view/$1');
$routes->get('/products/collections/(:segment)', 'ProductController::category/$1');

//login, register, logout, reset password
$routes->get('/member-login', 'UserController::index');
$routes->post('/member-login', 'UserController::login');
$routes->post('/member-register', 'UserController::register');
$routes->get('/verify', 'UserController::verify');
$routes->post('/member-reset-password', 'UserController::resetPassword');
$routes->get('/member-logout', 'UserController::logout');

//authenticated users
$routes->post('/profile-update', 'UserController::profileUpdate', ['filter' => 'auth']);
$routes->post('/change-password', 'UserController::changePassword', ['filter' => 'auth']);
$routes->get('/dashboard', 'UserController::dashboard', ['filter' => 'auth']);
$routes->get('my-rentals', 'UserController::myRentals', ['filter' => 'auth']);
$routes->get('my-rentals/(:num)', 'UserController::viewRental/$1', ['filter' => 'auth']);
$routes->get('my-transactions', 'UserController::myTransactions', ['filter' => 'auth']);
$routes->get('my-transactions/(:num)', 'UserController::viewTransaction/$1', ['filter' => 'auth']);
$routes->get('my-saved-items', 'UserController::mysavedCarts', ['filter' => 'auth']);
$routes->post('transaction-details', 'PaymentController::getTransaction', ['filter' => 'auth']);
$routes->post('support-request', 'SupportController::supportRequest', ['filter' => 'auth']);


//authenticated users w/ payment
$routes->get('/payment-home', 'PaymentController::index', ['filter' => 'auth']);
$routes->get('/payment', 'PaymentController::payment', ['filter' => 'auth']);
$routes->get('/payment/success', 'PaymentController::payment_success', ['filter' => 'auth']);
$routes->get('/payment/cancel', 'PaymentController::payment_cancel', ['filter' => 'auth']);

//cart and checkout
$routes->get('/cart', 'CartController::index');
$routes->get('/checkout', 'CartController::checkout', ['filter' => 'auth']);
$routes->post('/updateShipping', 'CartController::updateShipping', ['filter' => 'auth']);
$routes->post('/updateShippingOption', 'CartController::updateShippingOption', ['filter' => 'auth']);
$routes->post('/update-shipping-details', 'UserController::updateShippingAddress', ['filter' => 'auth']);
$routes->post('/cart/add', 'CartController::add');
$routes->post('/cart/update', 'CartController::update');
$routes->post('/cart/remove', 'CartController::remove');
$routes->post('/save-cart', 'CartController::saveCart', ['filter' => 'auth']);
$routes->get('/get-saved-cart', 'CartController::getSavedCart', ['filter' => 'auth']);
$routes->get('/load-saved-cart', 'CartController::loadSavedCart', ['filter' => 'auth']);
$routes->post('/delete-saved-cart', 'CartController::deleteSavedCart', ['filter' => 'auth']);
$routes->get('/get-rates', 'ShippingController::myRates');
$routes->post('/getShippingCost', 'ShippingController::myRates');
$routes->get('/testOrderRate', 'ShippingController::testOrderRate');

//form actions
$routes->post('get-variant-colors', 'ProductController::colorVariants');
$routes->get('variant-color', 'ProductController::colorVariant');

//error pages
$routes->set404Override('App\Controllers\Home::pagenotfound');

//3rd party auth
$routes->get('/auth/kinde/callback', 'Auth::callback');
