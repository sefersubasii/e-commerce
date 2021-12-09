<?php

Route::group(['prefix' => 'api', 'middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::get('/', 'ApiController@index');
    Route::get('orders', 'OrderResource@index');
    Route::get('orders/{id}', 'OrderResource@show');
});

/*
Route::get('test/fb', function () {

$finansbank = new Finansbank();

// Sipariş bilgileri
$order = [
'id'          => '',
'name'        => 'John Doe', // zorunlu değil
'email'       => 'mail@customer.com', // zorunlu değil
'user_id'     => '12', // zorunlu değil
'amount'      => (float) 20, // Sipariş tutarı
'currency'    => 'TRY',
'ip'          => $_SERVER['REMOTE_ADDR'],
'transaction' => 'pay', // pay => Auth, pre PreAuth (Direkt satış için pay, ön provizyon için pre)
];

session()->put('order', $order);

// Kredi kartı bilgieri
$card = [
'name'   => 'Test Card',
'number' => '5456165456165454', // Kredi kartı numarası
'month'  => '12', // SKT ay
'year'   => '26', // SKT yıl, son iki hane
'cvv'    => '000', // Güvenlik kodu, son üç hane
'type'   => 'master', // visa, master
];

$finansbank->prepare($order, $card);

$formData = $finansbank->get3dFormData();

echo '<form id="webpos_form" name="webpos_form" action="' . $formData['gateway'] . '" method="POST">';
foreach ($formData['inputs'] as $name => $value) {
echo '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
}
echo '</form> <script>document.querySelector("#webpos_form").submit()</script>';
});
 */

// Route::post('finansbank/callback', 'baseController@finansbankCallback');

Route::get('urlList', 'baseController@urlList');
Route::get('importExcel', 'baseController@importExcel');

Route::get('yurticiKargo', 'baseController@yurticiKargo');
Route::get('yurticiKargoQs', 'baseController@QueryShipmentYk');

Route::get('yurticiKargoQsBulk', 'OrdersController@QueryShipmentYkBulk');

// Gönderilmemiş Kargoları Tekrar Gönder
Route::get('resendCargo', 'OrdersController@resendCargo');

Route::get('suratKargo', 'baseController@suratKargo');
Route::get('n11', 'baseController@n11');
Route::get('analytics/', 'baseController@analytics');
Route::get('titles/', 'baseController@categoryTest');
Route::get('resizeImg/', 'baseController@resizeImg');
Route::get('convertImg/', 'baseController@convertImg');

Route::get('output/product/{permCode}', 'OutputController@outputProductXml');

Route::get('/', 'HomeController@index');

Route::get('StMapCreate', 'SitemapController@create');
// Route::get('StMapCreate', 'baseController@createSitemap');

Route::post('saveAddress', 'AddressController@saveAddress');
Route::get('getAddress', 'AddressController@getAddress');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index');

    ## Yorum ##
    Route::get('comments/datatables', 'CommentController@datatables')->name('admin.comments.datatables');
    Route::resource('comments', 'CommentController');

    Route::get('analytics/', 'DashboardController@analytics');

    Route::get('cache/clear', 'DashboardController@cacheClear');

    //Route::get('user', 'userController@index');
    Route::get('user/datatable', 'UserController@datatable');
    Route::get('user/delete/{id}', 'UserController@destroy');
    Route::resource('user', 'UserController');

    //Route::get('user','UserController@index');
    //Route::post('user','UserController@store');
    //Route::get('user/create','UserController@create');
    //Route::get('user/{id}/edit','UserController@edit');
    //Route::put('user/{id}','UserController@update');
    //Route::post('user/update','UserController@update');
    //Route::post('user/edit','UserController@update');
    //Route::patch('user/{id}/update', ['as' => 'user.update', 'uses' => 'UserController@update']);

    Route::get('role/datatable', 'RoleController@dataTable');
    Route::get('role/delete/{id}', 'RoleController@delete');
    Route::get('role/ajaxList', 'RoleController@ajaxList');
    Route::resource('role', 'RoleController');

    Route::get('customers', 'CustomerController@index')->middleware('permission:customer_read');
    Route::get('customers/datatable', 'CustomerController@customersDatatable');
    Route::get('customers/add', 'CustomerController@addCustomer')->middleware('permission:customer_create');
    Route::post('customers/create', 'CustomerController@createCustomer')->middleware('permission:customer_create');
    Route::get('customers/edit/{id}', 'CustomerController@editCustomer')->middleware('permission:customer_edit');
    Route::post('customers/update/{id}', 'CustomerController@updateCustomer')->middleware('permission:customer_edit');
    Route::get('customers/delete/{id}', 'CustomerController@DeleteCustomer')->middleware('permission:customer_delete');
    Route::get('customers/outputCustomersExcel', 'DashboardController@outputCustomersExcel')->middleware('permission:customer_read');

    Route::get('customers/stats', 'CustomerController@stats');

    Route::get('customerGroups', 'CustomerGroupController@index');
    Route::get('customerGroups/datatable', 'CustomerGroupController@Datatable');
    Route::get('customerGroups/add', 'CustomerGroupController@add');
    Route::post('customerGroups/create', 'CustomerGroupController@create');
    Route::get('customerGroups/edit/{id}', 'CustomerGroupController@edit');
    Route::post('customerGroups/update/{id}', 'CustomerGroupController@update');
    Route::get('customerGroups/delete/{id}', 'CustomerGroupController@delete');
    Route::get('customerGroups/ajax/list', 'CustomerGroupController@ajaxList');

    Route::get('countries', 'CountriesController@index');
    Route::get('countries/add', 'CountriesController@addCountry');
    Route::post('countries/create', 'CountriesController@createCountry');
    Route::get('countries/edit/{id}', 'CountriesController@editCountry');
    Route::post('countries/update/{id}', 'CountriesController@updateCountry');
    Route::get('countries/datatable', 'CountriesController@countriesDatatable');
    Route::get('countries/ajax/list', 'CountriesController@ajaxList');
    Route::get('countries/delete/{id}', 'CountriesController@DeleteCountries');

    Route::get('cities', 'CitiesController@index');
    Route::get('cities/add', 'CitiesController@addCities');
    Route::post('cities/create', 'CitiesController@createCities');
    Route::get('cities/edit/{id}', 'CitiesController@editCities');
    Route::post('cities/update/{id}', 'CitiesController@updateCities');
    Route::get('cities/datatable', 'CitiesController@citiesDatatable');
    Route::get('cities/ajax/list', 'CitiesController@ajaxList');
    Route::get('cities/delete/{id}', 'CitiesController@DeleteCities');

    Route::get('districts', 'DistrictsController@index');
    Route::get('districts/add', 'DistrictsController@addCities');
    Route::post('districts/create', 'DistrictsController@createCities');
    Route::get('districts/edit/{id}', 'DistrictsController@editCities');
    Route::post('districts/update/{id}', 'DistrictsController@updateCities');
    Route::get('districts/datatable', 'DistrictsController@citiesDatatable');
    Route::get('districts/ajax/list', 'DistrictsController@ajaxList');
    Route::get('districts/delete/{id}', 'DistrictsController@DeleteCities');

    Route::get('mail/groupList', 'MailController@groupList');
    Route::get('mail/groupList/datatable', 'MailController@groupListDatatable');
    Route::get('mail/mailGroup/ajaxList', 'MailController@mailGroupAjaxList');
    Route::post('mail/mailGroupShortEdit', 'MailController@mailGroupShortEdit');
    Route::post('mail/mailGroupShortUpdate/{id}', 'MailController@mailGroupShortUpdate');
    Route::post('mail/mailGroupCreate', 'MailController@mailGroupCreate');
    Route::get('mail/mailGroup/delete/{id}', 'MailController@mailGroupDelete');
    Route::get('mail/maillist', 'MailController@mailList');
    Route::get('mail/mailList/datatable', 'MailController@mailListDatatable');
    Route::post('mail/mailListShortEdit', 'MailController@mailListShortEdit');
    Route::post('mail/mailListShortUpdate/{id}', 'MailController@mailListShortUpdate');
    Route::get('mail/mailList/delete/{id}', 'MailController@mailListDelete');

    Route::get('reviews', 'ReviewController@index');
    Route::get('reviews/datatable', 'ReviewController@datatable');
    Route::get('reviews/edit/{id}', 'ReviewController@edit');
    Route::post('review/update/{id}', 'ReviewController@update');
    Route::get('reviews/delete/{id}', 'ReviewController@delete');

    Route::get('refundRequests', 'RefundRequestsController@index');
    Route::get('refundRequests/datatable', 'RefundRequestsController@datatable');
    Route::get('refundRequests/edit/{id}', 'RefundRequestsController@edit');
    Route::post('refundRequests/update', 'RefundRequestsController@update');
    Route::get('refundRequests/delete/{id}', 'RefundRequestsController@delete');

    Route::get('stockWarnings', 'StockWarningController@index');
    Route::get('stockWarnings/datatable', 'StockWarningController@datatable');
    Route::get('stockWarnings/delete/{id}', 'StockWarningController@delete');

    Route::get('bulkOperations', 'bulkOperationsController@index')->middleware('permission:product_edit');
    Route::get('bulkOperations/template', 'bulkOperationsController@template')->middleware('permission:product_edit');
    Route::post('bulkOperations/ajaxTotalProducts', 'bulkOperationsController@TotalProducts');
    Route::post('bulkOperations/process', 'bulkOperationsController@process')->middleware('permission:product_edit');

    Route::get('products', 'ProductsController@index')->middleware('permission:product_read');

    Route::get('products/add', 'ProductsController@add')->middleware('permission:product_create');

    Route::post('products/datatable', 'ProductsController@productsDatatable');
    Route::get('products/ajax/list', 'ProductsController@ajaxList');
    Route::post('products/create', 'ProductsController@createProduct')->middleware('permission:product_create');
    Route::get('products/edit/{id}', 'ProductsController@editProduct')->middleware('permission:product_edit');
    Route::post('products/imageUpload', 'ProductsController@imageUpload');
    Route::get('products/imageRemove', 'ProductsController@imageRemove');
    Route::get('products/imageSorting', 'ProductsController@imageSort');
    Route::post('products/update/{id}', 'ProductsController@updateProduct')->middleware('permission:product_edit');
    Route::get('products/delete/{id}', 'ProductsController@productsDelete')->middleware('permission:product_delete');
    Route::get('products/ajax/relateds/{id}', 'ProductsController@productsRelatedsAjax');
    Route::get('products/relatedProducts', 'ProductsController@productsRelated');
    Route::post('products/sortStatus/update', 'ProductsController@sortStatusUpdate');
    Route::get('products/copy/{id}', 'ProductsController@productsCopy');
    Route::post('products/createCopy', 'ProductsController@createCopyProduct')->middleware('permission:product_create');
    Route::post('products/shortEdit', 'ProductsController@shortEdit')->middleware('permission:product_edit');
    Route::post('products/shortUpdate/{id}', 'ProductsController@shortUpdate')->middleware('permission:product_edit');
    Route::post('products/bulk/transport', 'ProductsController@bulkTransport')->middleware('permission:product_edit');
    Route::get('products/criticalStock/datatable', 'ProductsController@criticalStock');
    Route::get('products/outputProductEcxell', 'DashboardController@outputProductsExcel');
    Route::get('products/stats', 'ProductsController@stats');

    Route::get('productButton', 'ProductButonController@index');
    Route::get('productButton/datatable', 'ProductButonController@Datatable');
    Route::post('productButton/update', 'ProductButonController@updateStatus');
    Route::get('productButton/descriptions', 'ProductButonController@descriptions');
    Route::post('productButton/descriptions/update', 'ProductButonController@updatePD');

    Route::get('sortHome', 'productSortController@index');
    Route::get('sortPopular', 'productSortController@popular');

    Route::get('sortCategori', 'productSortController@categori');
    Route::get('sortCategori/ajax/list', 'productSortController@sortCategoriAjaxList');
    Route::post('sortCategori/getList', 'productSortController@sortCategoriGetList');

    Route::get('sortBrand', 'productSortController@brand');
    Route::post('sortBrand/getList', 'productSortController@sortBrandGetList');

    Route::get('sortNew', 'productSortController@newSort');
    Route::get('sortSponsor', 'productSortController@sponsor');
    Route::get('sortDiscount', 'productSortController@discount');

    Route::post('sortDiscount', 'productSortController@discountPost');
    Route::post('sortBrand', 'productSortController@brandPost');
    Route::post('sortCategori', 'productSortController@categoriPost');
    Route::post('sortHome', 'productSortController@homePost');
    Route::post('sortPopular', 'productSortController@popularPost');
    Route::post('sortNew', 'productSortController@newPost');
    Route::post('sortSponsor', 'productSortController@sponsorPost');

    Route::get('attributeGroups', 'AttributesController@index');
    Route::get('attributeGroups/datatable', 'AttributesController@attributeGroupsDatatable');
    Route::get('attributeGroups/add', 'AttributesController@addAttributeGroups');
    Route::post('attributeGroups/create', 'AttributesController@createAttributeGroups');
    Route::get('attributeGroups/edit/{id}', 'AttributesController@editAttributeGroups');
    Route::post('attributeGroups/update/{id}', 'AttributesController@updateAttributeGroups');
    Route::get('attributeGroups/delete/{id}', 'AttributesController@attributeGroupsDelete');
    Route::get('attributeGroups/ajax/list', 'AttributesController@attributeGroupsAjaxList');
    Route::get('attributeGroups/ajax/getGroup', 'AttributesController@attributeGroupsAjaxGetGroup');
    Route::get('attributeGroups/ajax/getAttributeValues', 'AttributesController@attributeGroupsAjaxGetAttributeValues');

    Route::get('attributes', 'AttributesController@attributes');
    Route::get('attributes/datatable', 'AttributesController@attributeDatatable');
    Route::get('attribute/add', 'AttributesController@addAttribute');
    Route::get('attribute/addAttributeArea', 'AttributesController@addAttributeArea');
    Route::post('attribute/create', 'AttributesController@createAttribute');
    Route::get('attribute/edit/{id}', 'AttributesController@editAttribute');
    Route::post('attribute/update/{id}', 'AttributesController@updateAttribute');
    Route::get('attribute/delete/{id}', 'AttributesController@attributeDelete');

    Route::get('brands/', 'BrandsController@index');
    Route::get('brands/add', 'BrandsController@add');
    Route::get('brands/ajax/list', 'BrandsController@ajaxList');
    Route::get('brands/edit/{id}', 'BrandsController@editBrand');
    Route::post('brands/create', 'BrandsController@createBrand');
    Route::post('brands/update/{id}', 'BrandsController@updateBrand');
    Route::get('brands/datatable', 'BrandsController@brandsDatatable');
    Route::get('brands/delete/{id}', 'BrandsController@brandsDelete');
    Route::post('brands/createshort', 'BrandsController@createShort');

    Route::get('categories/', 'CategoriesController@index')->middleware('permission:category_read');
    Route::get('categories2/', 'CategoriesController@category2');
    Route::get('categoriSeo/', 'CategoriesController@categorySoe');
    Route::get('categories/datatable', 'CategoriesController@categoriesDatatable');
    Route::get('categories/datatable2', 'CategoriesController@categoriesDatatable2');
    Route::get('categories/add', 'CategoriesController@addCategory')->middleware('permission:category_create');
    Route::get('categories/ajax/list', 'CategoriesController@ajaxList');
    Route::post('categories/create', 'CategoriesController@createCategory')->middleware('permission:category_create');
    Route::get('categories/delete/{id}', 'CategoriesController@categoryDelete')->middleware('permission:category_delete');
    Route::get('categories/edit/{id}', 'CategoriesController@editCategory')->middleware('permission:category_edit');
    Route::post('categories/update/{id}', 'CategoriesController@updateCategory')->middleware('permission:category_edit');
    Route::get('categories/nestable', 'CategoriesController@nestableCategory');
    Route::get('categories/selectNestableCategory/{id}', 'CategoriesController@selectNestableCategory');
    Route::post('categories/shortUpdateSort', 'CategoriesController@shortUpdateSort');
    Route::post('categories/getCategories', 'CategoriesController@getCategories');
    Route::post('categories/imageDelete', 'CategoriesController@categoryImageDelete')->middleware('permission:category_edit');
    Route::post('categories/imageCoverDelete', 'CategoriesController@categoryImageCoverDelete')->middleware('permission:category_edit');

    Route::get('campaigns/coupons', 'CampaignsController@coupons')->middleware('permission:campaign_read');
    Route::get('campaigns/coupons/datatable', 'CampaignsController@couponsDatatable');
    Route::get('campaigns/coupons/add', 'CampaignsController@couponsAdd')->middleware('permission:campaign_create');
    Route::post('campaigns/coupons/create', 'CampaignsController@createCoupon')->middleware('permission:campaign_create');
    Route::get('campaigns/coupons/edit/{id}', 'CampaignsController@editCoupon')->middleware('permission:campaign_edit');
    Route::post('campaigns/coupons/update/{id}', 'CampaignsController@updateCoupon')->middleware('permission:campaign_edit');
    Route::get('campaigns/coupons/delete/{id}', 'CampaignsController@couponDelete')->middleware('permission:campaign_delete');

    Route::get('campaigns/promotion', 'CampaignsController@promotion')->middleware('permission:campaign_read');
    Route::get('campaigns/promotion/datatable', 'CampaignsController@promotionsDatatable')->middleware('permission:campaign_read');
    Route::get('campaigns/promotion/add', 'CampaignsController@promotionAdd')->middleware('permission:campaign_create');
    Route::post('campaigns/promotion/create', 'CampaignsController@createPromotion')->middleware('permission:campaign_create');
    Route::get('campaigns/promotion/delete/{id}', 'CampaignsController@promotionDelete')->middleware('permission:campaign_delete');
    Route::get('campaigns/promotion/edit/{id}', 'CampaignsController@editPromotion')->middleware('permission:campaign_edit');
    Route::post('campaigns/promotion/update/{id}', 'CampaignsController@updatePromotion')->middleware('permission:campaign_edit');

    Route::get('variants/add', 'VariantsController@variantsAdd');
    Route::get('variants', 'VariantsController@index');
    Route::get('variants/datatable', 'VariantsController@variantsDatatable');
    Route::get('variants/ajax/add-area', 'VariantsController@variantsAddarea');
    Route::get('variants/ajax/list', 'VariantsController@ajaxList');
    Route::get('variants/ajax/group', 'VariantsController@ajaxGroup');
    Route::post('variants/ajax/table', 'VariantsController@ajaxTable');
    Route::post('variants/create', 'VariantsController@createVariant');
    Route::get('variants/edit/{id}', 'VariantsController@editVariant');
    Route::post('variants/update/{id}', 'VariantsController@updateVariant');
    Route::get('variants/delete/{id}', 'VariantsController@deleteVariant');

    Route::get('shippingCompanies', 'ShippingController@index');
    Route::get('shippingCompanies/add', 'ShippingController@addShippingCompanies');
    Route::post('shippingCompanies/create', 'ShippingController@createShippingCompanies');
    Route::get('shippingCompanies/datatable', 'ShippingController@shippingCompaniesDatatable');
    Route::get('shippingCompanies/edit/{id}', 'ShippingController@editshippingCompanies');
    Route::post('shippingCompanies/update/{id}', 'ShippingController@updateShippingCompanies');
    Route::get('shippingCompanies/delete/{id}', 'ShippingController@deleteShippingCompanies');
    Route::get('shippingCompanies/ajax/list', 'ShippingController@ajaxList');

    Route::get('shippingRoles', 'ShippingController@roles');
    Route::get('shippingRoles/add', 'ShippingController@AddRoles');
    Route::get('shippingRoles/datatable', 'ShippingController@RolesDatatable');
    Route::post('shippingRoles/create', 'ShippingController@createRoles');
    Route::get('shippingRoles/edit/{id}', 'ShippingController@editRole');
    Route::post('shippingRoles/update/{id}', 'ShippingController@updateRole');
    Route::get('shippingRoles/delete/{id}', 'ShippingController@deleteRole');

    Route::get('pages', 'PagesController@index');
    Route::get('pages/add', 'PagesController@addPages');
    Route::post('pages/create', 'PagesController@createPages');
    Route::get('pages/datatable', 'PagesController@pagesDatatable');
    Route::get('pages/delete/{id}', 'PagesController@deletePages');
    Route::get('pages/edit/{id}', 'PagesController@editPages');
    Route::post('pages/update/{id}', 'PagesController@updatePages');

    Route::get('settings/basic', 'SettingsBasicController@index');
    Route::post('settings/basic/update', 'SettingsBasicController@update');
    Route::get('settings/sliders', 'SettingsBasicController@sliders');
    Route::get('settings/sliders/datatable', 'SettingsBasicController@slidersDatatable');
    Route::get('settings/slider/edit/{id}', 'SettingsBasicController@sliderEdit');
    Route::get('settings/slider/addArea', 'SettingsBasicController@sliderAddArea');
    Route::post('settings/slider/update/{id}', 'SettingsBasicController@sliderUpdate');
    Route::get('settings/sliderItems', 'SettingsBasicController@sliderItems');
    Route::get('settings/sliderItems/datatable/{id}', 'SettingsBasicController@sliderItemsDatatable');
    Route::get('settings/sliderItem/add', 'SettingsBasicController@sliderItemAdd');
    Route::post('settings/sliderItem/create/{id}', 'SettingsBasicController@sliderItemCreate');
    Route::get('settings/sliderItem/edit/{id}', 'SettingsBasicController@sliderItemEdit');
    Route::post('settings/sliderItem/update/{id}', 'SettingsBasicController@sliderItemUpdate');
    Route::get('settings/sliderItem/delete/{id}', 'SettingsBasicController@sliderItemDelete');
    Route::get('settings/popup', 'SettingsBasicController@popup');
    Route::get('settings/popup/datatable', 'SettingsBasicController@popupDatatable');
    Route::get('settings/popup/edit/{id}', 'SettingsBasicController@popupEdit');
    Route::post('settings/popup/update/{id}', 'SettingsBasicController@popupUpdate');
    Route::get('settings/popup/add', 'SettingsBasicController@popupAdd');
    Route::post('settings/popup/create', 'SettingsBasicController@popupCreate');
    Route::get('settings/popup/delete/{id}', 'SettingsBasicController@popupDelete');
    Route::get('settings/banner', 'SettingsBasicController@banner');
    Route::get('settings/banner/datatable', 'SettingsBasicController@bannerDatatable');
    Route::get('settings/banner/edit/{id}', 'SettingsBasicController@bannerEdit');
    Route::post('settings/banner/update/{id}', 'SettingsBasicController@bannerUpdate');
    Route::post('settings/banner/imageRemove', 'SettingsBasicController@imageRemove');
    Route::get('settings/banks', 'SettingsBasicController@banks');
    Route::get('settings/banks/datatable', 'SettingsBasicController@banksDatatable');
    Route::get('settings/bank/detail/{id}', 'SettingsBasicController@bankEdit');
    Route::post('settings/bank/update/{id}', 'SettingsBasicController@bankUpdate');
    Route::get('settings/bank/delete/{id}', 'SettingsBasicController@bankDelete');
    Route::get('settings/bank/add', 'SettingsBasicController@bankAdd');
    Route::post('settings/bank/create', 'SettingsBasicController@bankCreate');

    Route::get('orders', 'OrdersController@index')->middleware('permission:order_read');
    Route::get('orders/detail/{id}', 'OrdersController@detail')->middleware('permission:order_read');
    Route::get('orders/delete/{id}', 'OrdersController@delete')->middleware('permission:order_delete');
    Route::get('orders/datatable', 'OrdersController@datatable');
    Route::get('orders/print/{id}', 'OrdersController@printOrder')->middleware('permission:order_read');
    Route::get('orders/print-shipping/{id}', 'OrdersController@printOrderShipping')->middleware('permission:order_read');
    Route::get('orders/test/{id}', 'OrdersController@test');
    Route::get('orders/invoiceSettings/{id}', 'OrdersController@invoiceSettings');
    Route::get('orders/invoiceCreator', 'OrdersController@invoiceCreator');
    Route::post('orders/bulk/status', 'OrdersController@updateBulkStatus')->middleware('permission:order_edit');

    Route::post('orders/bulk/updateOrderStatus', 'OrdersController@updateOrderStatus')->middleware('permission:order_edit');

    Route::post('orders/bulk/delete', 'OrdersController@bulkDelete')->middleware('permission:order_delete');
    Route::post('orders/updateShippingNum', 'OrdersController@updateShippingNumModal')->middleware('permission:order_edit');
    Route::post('orders/updateShippingNumSave/{id}', 'OrdersController@shortUpdateSave')->middleware('permission:order_edit');
    Route::post('orders/resendMail', 'OrdersController@resendMail');
    Route::get('orders/outputOrdersExcell', 'DashboardController@outputOrdersExcell');
    Route::post('orders/showNote', 'OrdersController@showNote')->middleware('permission:order_read');
    Route::post('orders/noteUpdate/{id}', 'OrdersController@updateNote')->middleware('permission:order_edit');
    Route::get('orders/stats', 'OrdersController@stats')->middleware('permission:order_read');

    Route::post('orders/createShipment', 'OrdersController@createShipment')->middleware('permission:order_edit');
    Route::get('failedOrders', 'OrdersController@failedOrders')->middleware('permission:order_read');

    Route::get('redirection', 'RedirectionController@index');
    Route::get('redirection/datatable', 'RedirectionController@datatable');
    Route::get('redirection/edit/{id}', 'RedirectionController@edit');
    Route::post('redirection/update/{id}', 'RedirectionController@update');
    Route::get('redirection/delete/{id}', 'RedirectionController@delete');
    Route::get('redirection/add', 'RedirectionController@add');
    Route::post('redirection/create', 'RedirectionController@create');

    Route::get('output/list', 'OutputController@index');
    Route::get('output/product/{permCode}', 'OutputController@outputProductXml');
    Route::get('output/export/{permCode}', 'OutputController@exportProductXml');
    Route::get('output/datatable', 'OutputController@datatable');
    Route::get('output/edit/{id}', 'OutputController@edit');
    Route::post('output/update/{id}', 'OutputController@update');
    Route::get('output/add', 'OutputController@add');
    Route::post('output/create', 'OutputController@create');
    Route::get('output/delete/{id}', 'OutputController@delete');
    Route::get('output/copy/{id}', 'OutputController@copy');
    Route::get('output/catMap/{id}', 'OutputController@catMap');
    Route::get('output/catMap/datatable/{id}', 'OutputController@catMapDatatable');
    Route::get('output/catMap/delete/{id}', 'OutputController@deletecatMap');
    Route::post('output/catMap/create', 'OutputController@createCatMap');

    Route::get('blog-categories', 'BlogController@categories');
    Route::get('blog-categories/add', 'BlogController@categoryAdd');
    Route::get('blog-categories/datatable', 'BlogController@categoryDatatable');
    Route::post('blog-categories/create', 'BlogController@createCategory');
    Route::get('blog-categories/edit/{id}', 'BlogController@editCategory');
    Route::post('blog-categories/update/{id}', 'BlogController@updateCategory');
    Route::get('blog-categories/delete/{id}', 'BlogController@deleteCategory');

    Route::get('articles', 'BlogController@articles');
    Route::get('article/datatable', 'BlogController@articleDatatable');
    Route::get('article/add', 'BlogController@articleAdd');
    Route::post('article/create', 'BlogController@articleCreate');
    Route::get('article/edit/{id}', 'BlogController@articleEdit');
    Route::post('article/update/{id}', 'BlogController@articleUpdate');
    Route::get('article/delete/{id}', 'BlogController@deleteArticle');

    Route::get('stats/reports', 'DashboardController@statsReports');
    Route::get('stats/reports/exportOrdersExcel', 'DashboardController@exportOrdersExcel');
    Route::get('stats/reports/exportProductsExcel', 'DashboardController@exportProductsExcel');
    Route::get('stats/reports/exportProductsSalesExcel', 'DashboardController@exportProductsSalesExcel');

    Route::get('stats/orders', 'DashboardController@statsOrders');
    Route::get('stats/products', 'DashboardController@statsProducts');
    Route::get('stats/customers', 'DashboardController@statsCustomers');

    Route::get('py/list', 'DashboardController@pylist');

    Route::get('n11/templates/datatable', 'DashboardController@n11datatable');
    Route::post('n11/templates/edit', 'DashboardController@n11templateEdit');
    Route::get('n11/templates/delete/{id}', 'DashboardController@n11templateDelete');
    Route::post('n11/templates/create', 'DashboardController@n11templateCreate');
    Route::post('n11/templates/update/{id}', 'DashboardController@n11templateUpdate');
    Route::get('n11/category/map', 'DashboardController@n11CatMap');
    Route::get('n11/category/map/datatable', 'DashboardController@n11CatMapDatatable');
    Route::post('n11/category/map/create', 'DashboardController@n11CatMapCreate');
    Route::get('n11/category/map/delete/{id}', 'DashboardController@n11CatMapDelete');
    Route::post('n11/getCategories', 'DashboardController@n11GetCategories');

    Route::get('processLog', 'DashboardController@processLog');
    Route::get('processLog/datatable', 'DashboardController@processLogDt');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    //Route::post('filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');

    Route::get('filemanager/errors', '\UniSharp\LaravelFilemanager\Controllers\LfmController@getErrors');

    Route::any('filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    Route::get('filemanager/jsonitems', '\UniSharp\LaravelFilemanager\Controllers\ItemsController@getItems');
    Route::get('filemanager/newfolder', '\UniSharp\LaravelFilemanager\Controllers\FolderController@getAddfolder');
    Route::get('filemanager/deletefolder', '\UniSharp\LaravelFilemanager\Controllers\FolderController@getDeletefolder');
    Route::get('filemanager/folders', '\UniSharp\LaravelFilemanager\Controllers\FolderController@getFolders');

    Route::get('filemanager/crop', '\UniSharp\LaravelFilemanager\Controllers\CropController@getCrop');
    Route::get('filemanager/cropimage', '\UniSharp\LaravelFilemanager\Controllers\CropController@getCropimage');
    Route::get('filemanager/cropnewimage', '\UniSharp\LaravelFilemanager\Controllers\CropController@getNewCropimage');
    Route::get('filemanager/rename', '\UniSharp\LaravelFilemanager\Controllers\RenameController@getRename');
    Route::get('filemanager/resize', '\UniSharp\LaravelFilemanager\Controllers\ResizeController@getResize');
    Route::get('filemanager/doresize', '\UniSharp\LaravelFilemanager\Controllers\ResizeController@performResize');
    Route::get('filemanager/download', '\UniSharp\LaravelFilemanager\Controllers\DownloadController@getDownload');
    Route::get('filemanager/delete', '\UniSharp\LaravelFilemanager\Controllers\DeleteController@getDelete');
    Route::get('filemanager/demo', '\UniSharp\LaravelFilemanager\Controllers\DemoController@index');

    // Get file when base_directory isn't public
    $images_url = 'filemanager/' . \Config::get('lfm.images_folder_name') . '/{base_path}/{image_name}';
    $files_url  = 'filemanager/' . \Config::get('lfm.files_folder_name') . '/{base_path}/{file_name}';
    Route::get($images_url, '\UniSharp\LaravelFilemanager\Controllers\RedirectController@getImage')
        ->where('image_name', '.*');
    Route::get($files_url, '\UniSharp\LaravelFilemanager\Controllers\RedirectController@getFIle')
        ->where('file_name', '.*');
});

Route::post('login', 'Auth\AuthController@login');
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::get('logout', 'Auth\AuthController@logout');

Route::group(["middleware" => "members"], function () {

    Route::get('order/detail/{id}', 'baseController@orderDetail');

    Route::get('order/shippingInfo/{id}', 'baseController@shippingInfo');

    Route::get('hesabim/siparisi-tekrarla/{id}', 'RepeatOrderController@store')->name('member.repeat-order');
    Route::get('hesabim/siparisi-tekrarla/stok-kontrol/{id}', 'RepeatOrderController@stockControl')->name('member.repeat-order.stock');

    Route::get('hesabim', 'baseController@account');
    Route::get('hesabim/siparisler', 'baseController@orders');
    Route::get('hesabim/sifre-degistir', 'baseController@changePass');

    Route::post('hesabim', 'baseController@accountUpdate');
    Route::post('hesabim/sifre-degistir', 'baseController@updatePass');

    Route::get('refundRequest/{id}', 'baseController@refundRequest');
    Route::post('refundRequest/{id}', 'baseController@refundRequestAdd');
});

Route::get('getPromotions', 'baseController@getPromotions');
Route::get('output/product/{permCode}', 'OutputController@outputProductXml');

//Route::get('downloadRemoteXml','baseController@downloadRemoteXml');
//Route::get('updateStokAndAmount','baseController@updateStokAndAmount');
Route::get('parseXmlBrands', 'baseController@parseXmlBrands');
Route::get('parseXmlCategories', 'baseController@parseXmlCategories');
Route::get('parseXmlProducs', 'baseController@parseXmlProducts');
Route::get('parseXmlMembers', 'baseController@parseXmlMembers');

// Route::get('elasticDelete', 'baseController@elasticDelete');
// Route::get('searchTest', 'baseController@elasticTest');
//Route::get('search','baseController@elasticSearch');

// Route::get('search', 'baseController@defaultSearch');
Route::get('search', 'SearchController@index');
Route::get('{brand}/search', 'SearchController@searchByBrand');
Route::get('c/{category}/search', 'SearchController@searchByCategory');

// Route::get('{brand}/search', 'baseController@testSearchBrand');
// Route::get('c/{category}/search/', 'baseController@testSearchcategory');

Route::post('bulten/kayit', 'baseController@bultenRegister');
Route::post('postReview', 'baseController@postReview');
Route::post('stockNotification', 'baseController@stockNotification');
Route::post('postSuggestion', 'baseController@postSuggestion');

//Blog

Route::get('blog', 'baseController@blog');
Route::get('blog/{category}', 'baseController@blogCategory');
Route::get('blog/{category}/{article}', 'baseController@blogDetail');
//yeni blog
Route::get('alisveris-rehberi', 'baseController@blog');
Route::get('alisveris-rehberi/{article}', 'baseController@blogDetail');

//statik sayfalar
Route::get('mesafeli-satis-sozlesmesi', 'baseController@mss');
Route::get('odeme-ve-teslimat', 'baseController@ovt');
Route::get('gizlilik-ve-guvenlik', 'baseController@gvg');
Route::get('iade-sartlari', 'baseController@is');

// Dinamik sayfalar
Route::get('sayfa/{slug}', 'baseController@getPages')->name('page');

//Cart

Route::get('sepet', 'baseController@getCart');
Route::post('getAddToCart', 'baseController@getAddToCart');
Route::get('remove/{id}', 'baseController@getRemoveItem');
Route::post('updateCart', 'baseController@getUpdateCart');
Route::get('sepet/fatura-teslimat', 'baseController@checkout');
Route::post('sepet/fatura-teslimat', 'baseController@setBilling');
Route::get('sepet/odeme', 'baseController@odeme');
Route::get('sepet/tesekkurler', 'baseController@orderResult');
Route::post('sepet/getCartShipping', 'baseController@getCartShipping');
Route::post('sepet/getDistricts', 'baseController@districtsRequest');
Route::post('sepet/createDeliveryAddress', 'baseController@createDeliveryAddress');
Route::post('sepet/changeDeliveryAddress', 'baseController@changeDeliveryAddress');
Route::post('sepet/createBillingAddress', 'baseController@createBillingAddress');
Route::post('sepet/changeBillingAddress', 'baseController@changeBillingAddress');

// QNB Finansbank Test
// if (isOffice()) {
//     // Route::post('sepet/approveOrder', 'baseController@approveOrder2');
// } else {
// }

Route::post('sepet/approveOrder', 'baseController@approveOrder');

Route::post('threedmodel/callback', 'baseController@threedmodelcallback');
Route::post('sepet/useCode', 'baseController@setCode');
Route::get('sepet/usePromotion/{id}', 'baseController@usePromotion');
Route::get('sepet/promotion/addProduct/{id}', 'baseController@addPromotionProduct');

Route::get('uye-ol-veya-ziyaretci', 'baseController@signOrGuest');
Route::get('uye-ol', 'baseController@signUp');
Route::post('uye-ol', 'baseController@signUpPost');
Route::get('uye-girisi', 'baseController@signIn');
Route::get('cikis-yap', 'baseController@memberLogout');
Route::get('sifremi-unuttum', 'baseController@forgotPassword');
Route::post('sifremi-unuttum', 'baseController@forgotPasswordPost');
Route::get('sifremi-unuttum/{token}', 'baseController@forgotPasswordToken');
Route::post('sifremi-unuttum/{token}', 'baseController@resetMemberPassword');
Route::post('uye-girisi', 'baseController@signInPost');

Route::get('iletisim', 'baseController@contact');
Route::get('iletisim-formu', 'baseController@contactForm');
Route::post('iletisim-formu', 'baseController@contactFormPost');

Route::get('/login/facebook', 'SocialAuthController@redirect');
Route::get('/callback/facebook', 'SocialAuthController@callback');

Route::get('/login/google', 'SocialAuthController@redirectGoogle');
Route::get('/callback/google', 'SocialAuthController@callbackGoogle');

Route::get('/captcha/{config?}', '\Mews\Captcha\CaptchaController@getCaptcha');

Route::post('ordertracking', 'baseController@ordertrackFooter');

Route::post('toptan-teklif-iste', 'WholesaleController@save')->name('wholesale');

Route::get('markalar', 'BrandPageController@index')->name('brand_page.index');

Route::get('{slug}', 'baseController@index');

Route::get('{brand}/{category}', 'baseController@brandCatogory')->name('brand_category');
