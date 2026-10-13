<?php

use CodeIgniter\Router\RouteCollection;

$uri = service('uri');
$serviceRoutes = [
    ['service', 'chat', 'sync']
];

$isServiceRoute = false;
foreach ($serviceRoutes as $routeSegments) {
    if ($uri->getTotalSegments() !== count($routeSegments)) {
        continue;
    }
    $match = true;
    for ($i = 0; $i < count($routeSegments); $i++) {
        if ($uri->getSegment($i + 1) !== $routeSegments[$i]) {
            $match = false;
            break;
        }
    }
    if ($match) {
        $isServiceRoute = true;
        break;
    }
}

if ($isServiceRoute) {
    $routes->post('service/chat/sync', 'ServiceController::syncChat');
    return;
}

$languages = getContextValue('languages');
$generalSettings = getContextValue('generalSettings');
$csrt = getContextValue('routes');

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/' . $csrt->affiliate . '/(:any)', 'HomeController::affiliate/$1');
$routes->get('cron/update-sitemap', 'HomeController::cronUpdateSitemap');
$routes->get('auth/unsubscribe', 'HomeController::unSubscribe');
$routes->get('connect-with-google', 'AuthController::connectWithGoogle');
$routes->get('manifest.json', 'FeedController::manifest');

/*
 * --------------------------------------------------------------------
 * Admin Routes
 * --------------------------------------------------------------------
 */

$routes->group($csrt->admin, function ($routes) {
    $routes->get('/', 'AdminController::index');

    // Auth
    $routes->get('login', 'AuthController::adminLogin');
    $routes->post('login-post', 'AuthController::adminLoginPost');

    // Navigation
    $routes->get('theme', 'AdminController::theme');
    $routes->get('homepage-manager', 'AdminController::homepageManager');
    $routes->get('edit-banner/(:num)', 'AdminController::editIndexBanner/$1');

    // Slider
    $routes->get('slider', 'AdminController::slider');
    $routes->get('edit-slider-item/(:num)', 'AdminController::editSliderItem/$1');

    // Page
    $routes->get('add-page', 'AdminController::addPage');
    $routes->get('edit-page/(:num)', 'AdminController::editPage/$1');
    $routes->get('pages', 'AdminController::pages');

    // Order
    $routes->get('orders', 'OrderAdminController::orders');
    $routes->get('order-details/(:num)', 'OrderAdminController::orderDetails/$1');
    $routes->get('transactions', 'OrderAdminController::transactions');
    $routes->get('digital-sales', 'OrderAdminController::digitalSales');

    // Product
    $routes->get('products', 'ProductController::products');
    $routes->get('product-details/(:num)', 'ProductController::productDetails/$1');
    $routes->get('featured-products-pricing', 'ProductController::featuredProductsPricing');

    // Payments
    $routes->get('membership-payments', 'AdminController::membershipPayments');
    $routes->get('promotion-payments', 'AdminController::promotionPayments');
    $routes->get('wallet-deposits', 'AdminController::walletDeposits');
    $routes->get('bank-transfer-reports', 'AdminController::bankTransferReports');

    // Bidding
    $routes->get('quote-requests', 'ProductController::quoteRequests');

    // Category
    $routes->get('add-category', 'CategoryController::addCategory');
    $routes->get('categories', 'CategoryController::categories');
    $routes->get('edit-category/(:num)', 'CategoryController::editCategory/$1');
    $routes->get('tags', 'CategoryController::tags');

    // Bulk
    $routes->get('bulk-category-upload', 'BulkController::categoryUpload');
    $routes->get('bulk-custom-field-upload', 'BulkController::bulkCustomFieldUpload');

    // Brand
    $routes->get('brands', 'CategoryController::brands');
    $routes->get('add-brand', 'CategoryController::AddBrand');
    $routes->get('edit-brand/(:num)', 'CategoryController::editBrand/$1');

    // Custom fields
    $routes->get('add-custom-field', 'CategoryController::addCustomField');
    $routes->get('custom-fields', 'CategoryController::customFields');
    $routes->get('edit-custom-field/(:num)', 'CategoryController::editCustomField/$1');
    $routes->get('custom-field-options/(:num)', 'CategoryController::customFieldOptions/$1');

    // Earnings
    $routes->get('earnings', 'EarningsController::earnings');
    $routes->get('payout-requests', 'EarningsController::payoutRequests');
    $routes->get('payout-settings', 'EarningsController::payoutSettings');
    $routes->get('add-payout', 'EarningsController::addPayout');
    $routes->get('seller-balances', 'EarningsController::sellerBalances');

    // Blog
    $routes->get('blog-add-post', 'BlogController::addPost');
    $routes->get('blog-posts', 'BlogController::posts');
    $routes->get('edit-blog-post/(:num)', 'BlogController::editPost/$1');
    $routes->get('blog-categories', 'BlogController::categories');
    $routes->get('edit-blog-category/(:num)', 'BlogController::editCategory/$1');

    // Comments & Contant & Reviews
    $routes->get('pending-product-comments', 'ProductController::pendingComments');
    $routes->get('product-comments', 'ProductController::comments');
    $routes->get('pending-blog-comments', 'BlogController::pendingComments');
    $routes->get('blog-comments', 'BlogController::comments');
    $routes->get('reviews', 'ProductController::reviews');
    $routes->get('contact-messages', 'AdminController::contactMessages');
    $routes->get('chat-messages', 'AdminController::chatMessages');

    // Abuse reports
    $routes->get('abuse-reports', 'AdminController::abuseReports');

    // Email blacklist
    $routes->match(['GET', 'POST'], 'email-blacklist', 'AdminController::emailBlacklist');

    // Ad spaces
    $routes->get('ad-spaces', 'AdminController::adSpaces');

    // SEO tools
    $routes->get('seo-tools', 'AdminController::seoTools');

    // Location
    $routes->get('location-settings', 'AdminController::locationSettings');
    $routes->get('countries', 'AdminController::countries');
    $routes->get('states', 'AdminController::states');
    $routes->get('add-country', 'AdminController::addCountry');
    $routes->get('edit-country/(:num)', 'AdminController::editCountry/$1');
    $routes->get('add-state', 'AdminController::addState');
    $routes->get('edit-state/(:num)', 'AdminController::editState/$1');
    $routes->get('cities', 'AdminController::cities');
    $routes->get('add-city', 'AdminController::addCity');
    $routes->get('edit-city/(:num)', 'AdminController::editCity/$1');

    // Membership
    $routes->get('users', 'MembershipController::users');
    $routes->get('user-login-activities', 'MembershipController::userLoginActivities');
    $routes->get('account-deletion-requests', 'MembershipController::accountDeletionRequests');
    $routes->get('shop-opening-requests', 'MembershipController::shopOpeningRequests');
    $routes->get('add-user', 'MembershipController::addUser');
    $routes->get('edit-user/(:num)', 'MembershipController::editUser/$1');
    $routes->get('user-details/(:num)', 'MembershipController::userDetails/$1');
    $routes->get('membership-plans', 'MembershipController::membershipPlans');
    $routes->get('edit-plan/(:num)', 'MembershipController::editPlan/$1');
    $routes->get('roles-permissions', 'MembershipController::rolesPermissions');
    $routes->get('add-role', 'MembershipController::addRole');
    $routes->get('edit-role/(:num)', 'MembershipController::editRole/$1');

    // Support
    $routes->get('knowledge-base', 'SupportAdminController::knowledgeBase');
    $routes->get('knowledge-base/add-content', 'SupportAdminController::addContent');
    $routes->get('knowledge-base/edit-content/(:num)', 'SupportAdminController::editContent/$1');
    $routes->get('knowledge-base-categories', 'SupportAdminController::categories');
    $routes->get('knowledge-base/add-category', 'SupportAdminController::addCategory');
    $routes->get('knowledge-base/edit-category/(:num)', 'SupportAdminController::editCategory/$1');
    $routes->get('support-tickets', 'SupportAdminController::supportTickets');
    $routes->get('support-ticket/(:num)', 'SupportAdminController::supportTicket/$1');

    // Refund
    $routes->get('refund-requests', 'OrderAdminController::refundRequests');
    $routes->get('refund-requests/(:num)', 'OrderAdminController::refund/$1');

    // Languages
    $routes->get('language-settings', 'LanguageController::languageSettings');
    $routes->get('edit-language/(:num)', 'LanguageController::editLanguage/$1');
    $routes->get('edit-translations/(:num)', 'LanguageController::editTranslations/$1');
    $routes->get('search-phrases', 'LanguageController::searchPhrases');

    // Newsletter
    $routes->get('newsletter', 'AdminController::newsletter');
    $routes->get('newsletter-send-email', 'AdminController::newsletterSendEmail');

    // Affiliate program
    $routes->get('affiliate-program', 'AdminController::affiliateProgram');

    // Currency
    $routes->get('currency-settings', 'AdminController::currencySettings');
    $routes->get('add-currency', 'AdminController::addCurrency');
    $routes->get('edit-currency/(:num)', 'AdminController::editCurrency/$1');

    // Settings
    $routes->get('general-settings', 'AdminController::generalSettings');
    $routes->get('email-settings', 'AdminController::emailSettings');
    $routes->get('social-login', 'AdminController::socialLoginSettings');
    $routes->get('visual-settings', 'AdminController::visualSettings');
    $routes->get('preferences', 'AdminController::preferences');
    $routes->get('product-settings', 'AdminController::productSettings');
    $routes->get('font-settings', 'AdminController::fontSettings');
    $routes->get('edit-font/(:num)', 'AdminController::editFont/$1');
    $routes->get('route-settings', 'AdminController::routeSettings');
    $routes->get('cache-system', 'AdminController::cacheSystem');
    $routes->get('payment-settings', 'AdminController::paymentSettings');
    $routes->get('add-tax', 'AdminController::addTax');
    $routes->get('edit-tax/(:num)', 'AdminController::editTax/$1');

    // Category Selector
    $routes->get('categories/selector/list', 'AjaxController::selectorListCategories');
    $routes->get('categories/selector/search', 'AjaxController::selectorSearchCategories');
});

//home
$routes->post('contact-post', 'HomeController::contactPost');
$routes->post('set-selected-currency-post', 'HomeController::setSelectedCurrency');
$routes->post('submit-request-post', 'SupportController::submitRequestPost');
$routes->post('reply-ticket-post', 'SupportController::replyTicketPost');
$routes->get('download-attachment', 'SupportController::downloadAttachment');
//auth
$routes->post('login-post', 'AuthController::loginPost');
$routes->post('forgot-password-post', 'AuthController::forgotPasswordPost');
$routes->post('reset-password-post', 'AuthController::resetPasswordPost');
$routes->post('register-post', 'AuthController::registerPost');
$routes->get('confirm-account', 'AuthController::confirmAccount');
$routes->post('logout', 'AuthController::logout');
//bidding
$routes->post('bidding/submit-quote-post', 'DashboardController::submitQuotePost');
$routes->post('bidding/request-quote-post', 'OrderController::requestQuotePost');
$routes->post('bidding/accept-quote-post', 'OrderController::acceptQuote');
$routes->post('bidding/reject-quote-post', 'OrderController::rejectQuote');
//cart
$routes->post('cart/add-to-cart', 'CartController::addToCart');
$routes->post('add-to-cart-quote', 'CartController::addToCartQuote');
$routes->post('cart/update-quantity', 'CartController::updateCartItemQuantity');
$routes->post('cart/payment-method-post', 'CartController::paymentMethodPost');
$routes->post('cart/coupon-code-post', 'CartController::couponCodePost');
//checkout
$routes->post('checkout/complete-bank-transfer-order', 'CheckoutController::placeBankTransferOrder');
$routes->post('checkout/complete-paypal-payment', 'CheckoutController::completePaypalPayment');
$routes->post('checkout/complete-paystack-payment', 'CheckoutController::completePaystackPayment');
$routes->post('checkout/complete-razorpay-payment', 'CheckoutController::completeRazorpayPayment');
$routes->post('checkout/complete-midtrans-payment', 'CheckoutController::completeMidtransPayment');
$routes->post('checkout/complete-bank-transfer-payment', 'CheckoutController::completeBankTransferPayment');
$routes->post('checkout/complete-cash-on-delivery-payment', 'CheckoutController::completeCashOnDeliveryPayment');
$routes->post('checkout/complete-wallet-balance-payment', 'CheckoutController::completeWalletBalancePayment');
$routes->get('checkout/complete-stripe-payment', 'CheckoutController::completeStripePayment');
$routes->get('checkout/complete-flutterwave-payment', 'CheckoutController::completeFlutterwavePayment');
$routes->get('checkout/complete-iyzico-payment', 'CheckoutController::completeIyzicoPayment');
$routes->get('checkout/complete-yoomoney-payment', 'CheckoutController::completeYoomoneyPayment');
$routes->get('checkout/complete-paytabs-payment', 'CheckoutController::completePayTabsPayment');
$routes->get('checkout/complete-mercado-pago-payment', 'CheckoutController::completeMercadoPagoPayment');

//payment webhooks
$routes->post('payment/webhook/stripe', 'CheckoutController::handleStripeWebhook');
$routes->post('payment/webhook/paytabs', 'CheckoutController::handlePayTabsWebhook');
$routes->post('payment/webhook/razorpay', 'CheckoutController::handleRazorpayWebhook');
$routes->post('payment/webhook/yoomoney', 'CheckoutController::handleYooMoneyWebhook');
$routes->post('payment/webhook/mercado-pago', 'CheckoutController::handleMercadoPagoWebhook');

//order
$routes->post('submit-refund-request', 'OrderController::submitRefundRequest');
$routes->post('add-refund-message', 'OrderController::addRefundMessage');
//wallet
$routes->post('wallet/new-payout-request-post', 'ProfileController::newPayoutRequestPost');
$routes->post('wallet/set-payout-account-post', 'ProfileController::setPayoutAccountPost');
//message
$routes->post('send-message-post', 'HomeController::sendMessagePost');
//file
$routes->post('upload-digital-file-post', 'FileController::uploadDigitalFile');
$routes->post('upload-video-post', 'FileController::uploadVideo');
$routes->post('load-video-preview-post', 'FileController::loadVideoPreview');
$routes->post('download-purchased-digital-file-post', 'FileController::downloadPurchasedDigitalFile');
$routes->post('download-free-digital-file-post', 'FileController::downloadFreeDigitalFile');
//product
$routes->post('add-product-post', 'DashboardController::addProductPost');
$routes->post('edit-product-post', 'DashboardController::editProductPost');
$routes->post('edit-product-details-post', 'DashboardController::editProductDetailsPost');
$routes->post('start-selling-post', 'HomeController::startSellingPost');
//profile
$routes->post('social-media-post', 'ProfileController::socialMediaPost');
$routes->post('edit-profile-post', 'ProfileController::editProfilePost');
$routes->post('cover-image-post', 'ProfileController::coverImagePost');
$routes->post('follow-unfollow-user-post', 'ProfileController::followUnfollowUser');
$routes->post('change-password-post', 'ProfileController::changePasswordPost');
$routes->post('delete-account-post', 'ProfileController::deleteAccountPost');
$routes->post('add-shipping-address-post', 'ProfileController::addShippingAddressPost');
$routes->post('edit-shipping-address-post', 'ProfileController::editShippingAddressPost');
$routes->post('edit-location-post', 'ProfileController::locationPost');
//shop & shipping settings
$routes->post('shop-settings-post', 'DashboardController::shopSettingsPost');
$routes->post('add-shipping-zone-post', 'DashboardController::addShippingZonePost');
$routes->post('edit-shipping-zone-post', 'DashboardController::editShippingZonePost');
$routes->post('add-shipping-delivery-time-post', 'DashboardController::addShippingDeliveryTimePost');
$routes->post('edit-shipping-delivery-time-post', 'DashboardController::editShippingDeliveryTimePost');
//order dash
$routes->post('update-order-product-status-post', 'DashboardController::updateOrderProductStatusPost');
//promote
$routes->post('promote-product-post', 'DashboardController::promoteProductPost');
//coupon
$routes->post('add-coupon-post', 'DashboardController::addCouponPost');
$routes->post('edit-coupon-post', 'DashboardController::editCouponPost');

$routes->get('File/downloadShopDocument', 'FileController::downloadShopDocument');
$routes->get('Ajax/loadProducts', 'AjaxController::loadProducts');
$routes->get('ajax/run-queue-worker', 'AjaxController::runQueueWorker');

$postArray = [
    //Admin
    'Admin/editSliderSettingsPost',
    'Admin/deleteAbuseReportPost',
    'Admin/adSpacesPost',
    'Admin/googleAdsenseCodePost',
    'Admin/cacheSystemPost',
    'Admin/deleteContactMessagePost',
    'Admin/themePost',
    'Admin/generateSitemapPost',
    'Admin/downloadSitemapPost',
    'Admin/deleteSitemapPost',
    'Admin/seoToolsPost',
    'Admin/storageSettingsPost',
    'Admin/addCurrencyPost',
    'Admin/currencySettingsPost',
    'Admin/currencyConverterPost',
    'Admin/updateCurrencyRates',
    'Admin/deleteCurrencyPost',
    'Admin/editCurrencyPost',
    'Admin/editFontPost',
    'Admin/setSiteFontPost',
    'Admin/addFontPost',
    'Admin/deleteFontPost',
    'Admin/editIndexBannerPost',
    'Admin/homepageManagerPost',
    'Admin/deleteIndexBannerPost',
    'Admin/homepageManagerSettingsPost',
    'Admin/addIndexBannerPost',
    'Admin/setActiveLanguagePost',
    'Admin/downloadDatabaseBackup',
    'Admin/downloadFullBackup',
    'Admin/restoreFullBackupPost',
    'Admin/addCityPost',
    'Admin/addCountryPost',
    'Admin/addStatePost',
    'Admin/deleteCityPost',
    'Admin/deleteCountryPost',
    'Admin/locationSettingsPost',
    'Admin/editCityPost',
    'Admin/editCountryPost',
    'Admin/editStatePost',
    'Admin/deleteStatePost',
    'Admin/newsletterSelectEmailsPost',
    'Admin/deleteSubscriberPost',
    'Admin/newsletterSettingsPost',
    'Admin/newsletterSendEmailPost',
    'Admin/addPagePost',
    'Admin/editPagePost',
    'Admin/deletePagePost',
    'Admin/emailSettingsPost',
    'Admin/sendTestEmailPost',
    'Admin/emailOptionsPost',
    'Admin/generalSettingsPost',
    'Admin/captchaSettingsPost',
    'Admin/maintenanceModePost',
    'Admin/paymentGatewaySettingsPost',
    'Admin/commissionSettingsPost',
    'Admin/deleteTaxPost',
    'Admin/editTaxPost',
    'Admin/addTaxPost',
    'Admin/additionalInvoiceInfoPost',
    'Admin/preferencesPost',
    'Admin/aiWriterPost',
    'Admin/productSettingsPost',
    'Admin/routeSettingsPost',
    'Admin/socialLoginSettingsPost',
    'Admin/visualSettingsPost',
    'Admin/updateWatermarkSettingsPost',
    'Admin/editSliderItemPost',
    'Admin/addSliderItemPost',
    'Admin/deleteSliderItemPost',
    'Admin/activateInactivateCountries',
    'Admin/homepageManagerPost',
    'Admin/updateCurrencyRate',
    'Admin/affiliateProgramPost',
    'Admin/deleteChatPost',
    'Admin/deleteChatMessagePost',
    'Admin/approveMembershipPaymentPost',
    'Admin/approvePromotionPaymentPost',
    'Admin/approveWalletDepositPaymentPost',
    'Admin/deleteMembershipPaymentPost',
    'Admin/deletePromotionPaymentsPost',
    'Admin/bankTransferOptionsPost',
    'Admin/deleteWalletDepositPost',
    'Admin/deleteBankTransferPost',
    'Admin/deleteBlacklistEmail',
    //Ajax
    'Ajax/addRemoveWishlist',
    'Ajax/getStates',
    'Ajax/getCities',
    'Ajax/getSubCategories',
    'Ajax/searchCategories',
    'Ajax/getSubCategories',
    'Ajax/getBlogCategoriesByLang',
    'Ajax/getCountriesByContinent',
    'Ajax/getStatesByCountry',
    'Ajax/addComment',
    'Ajax/loadMoreComments',
    'Ajax/addReviewPost',
    'Ajax/loadMoreReviews',
    'Ajax/deleteComment',
    'Ajax/deleteReview',
    'Ajax/loadSubCommentForm',
    'Ajax/addBlogComment',
    'Ajax/loadMoreBlogComments',
    'Ajax/deleteBlogComment',
    'Ajax/addChatPost',
    'Ajax/loadChatPost',
    'Ajax/sendMessagePost',
    'Ajax/deleteChatPost',
    'Ajax/reportAbusePost',
    'Ajax/ajaxSearch',
    'Ajax/loadMorePromotedProducts',
    'Ajax/hideCookiesWarning',
    'Ajax/getProductShippingCost',
    'Ajax/addToNewsletter',
    'Ajax/createAffiliateLink',
    'Ajax/selectCouponCategoryPost',
    'Ajax/selectCouponProductPost',
    'Ajax/getProductTagSuggestions',
    'Ajax/loadMoreUsers',
    'Ajax/loadMoreSubscribers',
    'Ajax/generateAIContent',
    'Ajax/loadUsersDropdown',
    'Ajax/loadFilterOptions',
    'Ajax/loadActiveCountries',
    //Auth
    'Auth/sendActivationEmailPost',
    'Auth/joinAffiliateProgramPost',
    //Blog
    'Blog/addPostPost',
    'Blog/addCategoryPost',
    'Blog/deleteCategoryPost',
    'Blog/approveCommentPost',
    'Blog/deleteComment',
    'Blog/editCategoryPost',
    'Blog/editPostPost',
    'Blog/deletePostPost',
    'Blog/approveSelectedComments',
    'Blog/deleteSelectedComments',
    'Blog/deletePostImagePost',
    //Bulk Upload
    'Bulk/uploadCsvFilePost',
    'Bulk/processCsvChunk',
    'Bulk/downloadCsvFilesPost',
    //Cart
    'Cart/removeCartDiscountCoupon',
    'Cart/removeFromCart',
    'Cart/getShippingMethodsByLocation',
    'Cart/shippingPost',
    //Category
    'Category/deleteBrandPost',
    'Category/editBrandPost',
    'Category/brandSettingsPost',
    'Category/addBrandPost',
    'Category/addCategoryPost',
    'Category/addCustomFieldPost',
    'Category/generateCsvObjectPost',
    'Category/categorySettingsPost',
    'Category/deleteCategoryPost',
    'Category/loadCategories',
    'Category/editCustomFieldOptionPost',
    'Category/addCustomFieldOptionPost',
    'Category/addCategoryToCustomField',
    'Category/customFieldSettingsPost',
    'Category/addRemoveCustomFieldFiltersPost',
    'Category/deleteCustomFieldPost',
    'Category/editCategoryPost',
    'Category/editCustomFieldPost',
    'Category/deleteCustomFieldOption',
    'Category/deleteCategoryFromField',
    'Category/editFeaturedCategoriesOrderPost',
    'Category/editIndexCategoriesOrderPost',
    'Category/deleteCategoryImagePost',
    'Category/addTagPost',
    'Category/editTagPost',
    'Category/deleteTagPost',
    //Checkout
    'Checkout/bankTransferPaymentPost',
    //Dashboard
    'Dashboard/deleteCouponPost',
    'Dashboard/generateCsvObjectPost',
    'Dashboard/importCsvItemPost',
    'Dashboard/duplicateProductPost',
    'Dashboard/deleteProduct',
    'Dashboard/approveDeclineRefund',
    'Dashboard/deleteShippingLocationPost',
    'Dashboard/selectShippingMethod',
    'Dashboard/deleteShippingMethodPost',
    'Dashboard/deleteShippingZonePost',
    'Dashboard/deleteShippingDeliveryTimePost',
    'Dashboard/addShippingMethodPost',
    'Dashboard/editShippingMethodPost',
    'Dashboard/addLicenseKeys',
    'Dashboard/deleteLicenseKey',
    'Dashboard/loadLicenseKeysList',
    'Dashboard/getSubCategories',
    'Dashboard/affiliateProgramPost',
    'Dashboard/addRemoveAffiliateProductPost',
    'Dashboard/exportTableDataPost',
    'Dashboard/cashOnDeliverySettingsPost',
    'Dashboard/shopPoliciesPost',
    //Earnings
    'Earnings/addPayoutPost',
    'Earnings/deleteEarningPost',
    'Earnings/completePayoutRequestPost',
    'Earnings/deletePayoutPost',
    'Earnings/payoutSettingsPost',
    'Earnings/editSellerBalancePost',
    //File
    'File/uploadImage',
    'File/uploadImageSession',
    'File/getUploadedImage',
    'File/uploadBlogImage',
    'File/getSessUploadedImage',
    'File/downloadDigitalFile',
    'File/setImageMainSession',
    'File/setImageMain',
    'File/deleteImageSession',
    'File/deleteImage',
    'File/deleteVideo',
    'File/uploadAudio',
    'File/loadAudioPreview',
    'File/deleteAudio',
    'File/deleteDigitalFile',
    'File/getBlogImages',
    'File/deleteBlogImage',
    'File/loadMoreBlogImages',
    'File/uploadFileManagerImagePost',
    'File/getFileManagerImages',
    'File/deleteFileManagerImage',
    'File/exportTableDataPost',
    'File/uploadOptionImage',
    'File/loadUploadedOptionImages',
    'File/deleteOptionImage',
    //Home
    'Home/selectMembershipPlanPost',
    'Home/setDefaultLocationPost',
    'Home/bankTransferPaymentReportPost',
    //Language
    'Language/editLanguagePost',
    'Language/setDefaultLanguagePost',
    'Language/exportLanguagePost',
    'Language/deleteLanguagePost',
    'Language/addLanguagePost',
    'Language/importLanguagePost',
    'Language/editTranslationsPost',
    //Membership
    'Membership/addRolePost',
    'Membership/addUserPost',
    'Membership/editPlanPost',
    'Membership/editRolePost',
    'Membership/editUserPost',
    'Membership/addPlanPost',
    'Membership/settingsPost',
    'Membership/deletePlanPost',
    'Membership/deleteRolePost',
    'Membership/approveShopOpeningRequest',
    'Membership/deleteUserPost',
    'Membership/assignMembershipPlanPost',
    'Membership/changeUserRolePost',
    'Membership/confirmUserEmail',
    'Membership/banRemoveBanUser',
    'Membership/addDeleteUserAffiliateProgram',
    'Membership/loginToUserAccountPost',
    'Membership/rejectShopOpeningRequest',
    'Membership/cancelAccountDeleteRequestPost',
    //OrderAdmin
    'OrderAdmin/deleteDigitalSalePost',
    'OrderAdmin/approveGuestOrderProduct',
    'OrderAdmin/deleteOrderProductPost',
    'OrderAdmin/updateOrderProductStatusPost',
    'OrderAdmin/orderPaymentReceivedPost',
    'OrderAdmin/deleteOrderPost',
    'OrderAdmin/deleteTransactionPost',
    'OrderAdmin/approveRefundPost',
    //Order
    'Order/deleteQuoteRequest',
    'Order/addRefundMessage',
    'Order/cancelOrderPost',
    'Order/approveOrderProductPost',
    'Order/cancelOrderPost',
    'Order/deleteQuoteRequest',
    //Product
    'Product/deleteReviewPost',
    'Product/deleteCommentPost',
    'Product/deleteQuoteRequestPost',
    'Product/approveCommentPost',
    'Product/deleteCommentPost',
    'Product/deleteProductPermanently',
    'Product/deleteProduct',
    'Product/featuredProductsPricingPost',
    'Product/addRemoveFeaturedProduct',
    'Product/rejectProduct',
    'Product/approveProduct',
    'Product/deleteSelectedProducts',
    'Product/deleteSelectedProductsPermanently',
    'Product/bulkActionProductsPost',
    'Product/addRemoveSpecialOffer',
    'Product/restoreProduct',
    'Product/deleteSelectedReviews',
    'Product/approveSelectedComments',
    'Product/deleteSelectedComments',
    'Product/approveSelectedEditedProducts',
    //Profile
    'Profile/deleteCoverImagePost',
    'Profile/deleteShippingAddressPost',
    'Profile/addFundsPost',
    'Profile/deleteAffiliateLinkPost',
    //SupportAdmin
    'SupportAdmin/addCategoryPost',
    'SupportAdmin/addContentPost',
    'SupportAdmin/editCategoryPost',
    'SupportAdmin/editContentPost',
    'SupportAdmin/deleteContentPost',
    'SupportAdmin/deleteCategoryPost',
    'SupportAdmin/sendMessagePost',
    'SupportAdmin/deleteTicketPost',
    'SupportAdmin/changeTicketStatusPost',
    'SupportAdmin/getCategoriesByLang',
    //Support
    'Support/uploadSupportAttachment',
    'Support/deleteSupportAttachmentPost',
    'Support/closeTicketPost',
];

foreach ($postArray as $item) {
    $array = explode('/', $item);
    $routes->post($item, $array[0] . 'Controller::' . $array[1]);
}

/*
 * --------------------------------------------------------------------
 * Dynamic Routes
 * --------------------------------------------------------------------
 */

if (!empty($languages)) {
    foreach ($languages as $language) {
        $key = '';
        if ($generalSettings->site_lang != $language->id) {
            $key = $language->short_form . '/';
            $routes->get($language->short_form, 'HomeController::index');
        }
        $routes->get($key . $csrt->affiliate . '/(:any)', 'HomeController::affiliate/$1');
        //auth
        $routes->get($key . $csrt->register, 'AuthController::register');
        $routes->get($key . $csrt->register_success, 'AuthController::registerSuccess');
        $routes->get($key . $csrt->forgot_password, 'AuthController::forgotPassword');
        $routes->get($key . $csrt->reset_password, 'AuthController::resetPassword');
        //profile
        $routes->get($key . $csrt->profile . '/(:any)', 'ProfileController::profile/$1');
        $routes->get($key . $csrt->wishlist, 'HomeController::wishlist');
        $routes->get($key . $csrt->followers . '/(:any)', 'ProfileController::followers/$1');
        $routes->get($key . $csrt->following . '/(:any)', 'ProfileController::following/$1');
        $routes->get($key . $csrt->reviews . '/(:any)', 'ProfileController::reviews/$1');
        $routes->get($key . $csrt->my_reviews . '/(:any)', 'ProfileController::myReviews/$1');
        $routes->get($key . $csrt->shop_policies . '/(:any)', 'ProfileController::shopPolicies/$1');
        $routes->get($key . $csrt->my_coupons, 'ProfileController::myCoupons');
        //settings
        $routes->get($key . $csrt->settings, 'ProfileController::editProfile');
        $routes->get($key . $csrt->settings . '/' . $csrt->edit_profile, 'ProfileController::editProfile');
        $routes->get($key . $csrt->settings . '/' . $csrt->location, 'ProfileController::location');
        $routes->get($key . $csrt->settings . '/' . $csrt->shipping_address, 'ProfileController::shippingAddress');
        $routes->get($key . $csrt->settings . '/' . $csrt->affiliate_links, 'ProfileController::affiliateLinks');
        $routes->get($key . $csrt->settings . '/' . $csrt->social_media, 'ProfileController::socialMedia');
        $routes->get($key . $csrt->settings . '/' . $csrt->change_password, 'ProfileController::changePassword');
        $routes->get($key . $csrt->settings . '/' . $csrt->delete_account, 'ProfileController::deleteAccount');
        //wallet
        $routes->get($key . $csrt->wallet, 'ProfileController::wallet');
        //affiliate
        $routes->get($key . $csrt->affiliate_program, 'HomeController::affiliateProgram');
        //product
        $routes->get($key . $csrt->select_membership_plan, 'HomeController::selectMembershipPlan');
        $routes->get($key . $csrt->start_selling, 'HomeController::startSelling');
        $routes->get($key . $csrt->search, 'HomeController::search');
        $routes->get($key . $csrt->products, 'HomeController::products');
        $routes->get($key . $csrt->downloads, 'OrderController::downloads');
        //blog
        $routes->get($key . $csrt->blog, 'HomeController::blog');
        $routes->get($key . $csrt->blog . '/' . $csrt->tag . '/(:any)', 'HomeController::tag/$1');
        $routes->get($key . $csrt->blog . '/(:any)/(:any)', 'HomeController::post/$1/$2');
        $routes->get($key . $csrt->blog . '/(:any)', 'HomeController::blogCategory/$1');
        //shops
        $routes->get($key . $csrt->shops, 'HomeController::shops');
        //contact
        $routes->get($key . $csrt->contact, 'HomeController::contact');
        //chat
        $routes->get($key . $csrt->messages, 'HomeController::chat');
        //rss feeds
        $routes->get($key . $csrt->rss_feeds, 'HomeController::rssFeeds');
        $routes->get($key . 'rss/' . $csrt->latest_products, 'HomeController::latestProducts');
        $routes->get($key . 'rss/' . $csrt->featured_products, 'HomeController::featuredProducts');
        $routes->get($key . 'rss/' . $csrt->category . '/(:any)', 'HomeController::rssByCategory/$1');
        $routes->get($key . 'rss/' . $csrt->seller . '/(:any)', 'HomeController::rssBySeller/$1');
        //cart
        $routes->get($key . $csrt->cart, 'CartController::cart');
        $routes->get($key . $csrt->cart . '/' . $csrt->shipping, 'CartController::shipping');
        $routes->get($key . $csrt->cart . '/' . $csrt->payment_method, 'CartController::paymentMethod');
        $routes->get($key . $csrt->cart . '/' . $csrt->payment, 'CartController::payment');
        //orders
        $routes->get($key . $csrt->orders, 'OrderController::orders');
        $routes->get($key . $csrt->order_details . '/(:num)', 'OrderController::order/$1');
        $routes->get($key . $csrt->order_completed . '/(:num)', 'CheckoutController::orderCompleted/$1');
        $routes->get($key . $csrt->checkout . '/' . $csrt->service_payment_completed, 'CheckoutController::servicePaymentCompleted');
        $routes->get($key . 'invoice/(:num)', 'HomeController::invoice/$1');
        $routes->get($key . 'invoice-promotion/(:num)', 'HomeController::invoicePromotion/$1');
        $routes->get($key . 'invoice-membership/(:num)', 'HomeController::invoiceMembership/$1');
        $routes->get($key . 'invoice-wallet-deposit/(:num)', 'HomeController::invoiceWalletDeposit/$1');
        $routes->get($key . 'invoice-expense/(:num)', 'HomeController::invoiceExpense/$1');
        //refund
        $routes->get($key . $csrt->refund_requests, 'OrderController::refundRequests');
        $routes->get($key . $csrt->refund_requests . '/(:num)', 'OrderController::refund/$1');
        //bidding
        $routes->get($key . $csrt->quote_requests, 'OrderController::quoteRequests');
        //terms & conditions
        $routes->get($key . $csrt->terms_conditions, 'HomeController::termsConditions');
        //dashboard
        $routes->get($key . $csrt->dashboard, 'DashboardController::index');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->add_product, 'DashboardController::addProduct');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->product . '/' . $csrt->product_details . '/(:num)', 'DashboardController::editProductDetails/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->edit_product . '/(:num)', 'DashboardController::editProduct/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->products, 'DashboardController::products');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->bulk_product_upload, 'DashboardController::bulkProductUpload');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->sales, 'DashboardController::sales');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->sale . '/(:num)', 'DashboardController::sale/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->quote_requests, 'DashboardController::quoteRequests');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->cash_on_delivery, 'DashboardController::cashOnDelivery');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->payments, 'DashboardController::payments');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->comments, 'DashboardController::comments');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->reviews, 'DashboardController::reviews');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->shop_settings, 'DashboardController::shopSettings');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->shop_policies, 'DashboardController::shopPolicies');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->shipping_settings, 'DashboardController::shippingSettings');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->add_shipping_zone, 'DashboardController::addShippingZone');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->edit_shipping_zone . '/(:num)', 'DashboardController::editShippingZone/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->coupons, 'DashboardController::coupons');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->coupon_products . '/(:num)', 'DashboardController::couponProducts/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->add_coupon, 'DashboardController::addCoupon');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->edit_coupon . '/(:num)', 'DashboardController::editCoupon/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->refund_requests, 'DashboardController::refundRequests');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->refund_requests . '/(:num)', 'DashboardController::refund/$1');
        $routes->get($key . $csrt->dashboard . '/' . $csrt->affiliate_program, 'DashboardController::affiliateProgram');
        //help center
        $routes->get($key . $csrt->help_center, 'SupportController::helpCenter');
        $routes->get($key . $csrt->help_center . '/' . $csrt->tickets, 'SupportController::tickets');
        $routes->get($key . $csrt->help_center . '/' . $csrt->submit_request, 'SupportController::submitRequest');
        $routes->get($key . $csrt->help_center . '/' . $csrt->ticket . '/(:num)', 'SupportController::ticket/$1');
        $routes->get($key . $csrt->help_center . '/' . $csrt->search, 'SupportController::search');
        $routes->get($key . $csrt->help_center . '/' . $csrt->ticket . '/(:num)', 'SupportController::ticket/$1');
        $routes->get($key . $csrt->help_center . '/(:any)/(:any)', 'SupportController::article/$1/$2');
        $routes->get($key . $csrt->help_center . '/(:any)', 'SupportController::category/$1');

        if ($generalSettings->site_lang != $language->id) {
            $routes->get($key . '(:any)/(:any)/(:any)', 'HomeController::error404');
            $routes->get($key . '(:any)/(:any)', 'HomeController::subCategory/$1/$2');
            $routes->get($key . '(:any)', 'HomeController::any/$1');
        }
    }
}

$routes->get('(:any)/(:any)/(:any)', 'HomeController::error404');
$routes->get('(:any)/(:any)', 'HomeController::subCategory/$1/$2');
$routes->get('(:any)', 'HomeController::any/$1');
