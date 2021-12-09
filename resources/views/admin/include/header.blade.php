
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header">
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="ti-menu"></i>
            </a>
            <div class="top-left-part">
                <a class="logo" href="{{url("admin")}}">
                    <?php /*
                    <b><img src="{{asset('src/admin/plugins/images/eliteadmin-logo.png')}}" alt="home" /></b>
                    */ ?>
					<span class="hidden-xs">
						<img src="{{asset('src/admin/plugins/images/logo.png')}}" style="margin-left: 20px;height:60px;margin-bottom:10px" alt="home" />
					</span>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li>
                    <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light">
                        <i class="icon-arrow-left-circle ti-menu"></i>
                    </a>
                </li>
            </ul>
            <?php /*
            <ul class="nav navbar-top-links navbar-right pull-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                        <img src="{{asset('src/admin/plugins/images/user-avatar.png')}}" alt="user-img" width="36" class="img-circle">
                        <b class="hidden-xs">{{ Auth::user()->name }}</b>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated flipInY">
                        <li>
                            <a href="#">
                                <i class="ti-user"></i>
                                Hesabım
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="{{ url('/logout') }}">
                                <i class="fa fa-power-off"></i>
                                Çıkış Yap
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
            */ ?>
        </div>
    <!-- /.navbar-header -->
    </nav>
<!-- Left navbar-header -->
<div style="position:absolute;right:0;top: 0px;z-index: 99;" class="nav navbar-top-links navbar-right pull-right">
    <!-- /.dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" target="_blank" href="{{url('/')}}"  aria-haspopup="true" aria-expanded="false"> <i class="ti-"></i>Site Önizlemesi</a>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
            <img src="{{asset('src/admin/plugins/images/user-avatar.png')}}" alt="user-img" width="36" class="img-circle">
            <b class="hidden-xs">{{ Auth::user()->name }}</b>
        </a>
        <ul class="dropdown-menu dropdown-user animated flipInY">
            <li>
                <a href="#">
                    <i class="ti-user"></i>
                    Hesabım
                </a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ url('/logout') }}">
                    <i class="fa fa-power-off"></i>
                    Çıkış Yap
                </a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
</div>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
        <li class="sidebar-search hidden-sm hidden-md hidden-lg">
        <!-- input-group -->
        <div class="input-group custom-search-form">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span>
        </div>
        <!-- /input-group -->
        </li>
            @permission('product_read')
        <li>
            <a href="{{url('admin/products')}}" class="waves-effect {{Request::segment(2) == "products" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
                <span class="hide-menu">
                    Ürünler
                    <span class="fa arrow"></span>
                </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="javascript:void(0)">Ürünler<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/products')}}">Tüm Ürünler</a></li>
                        <li> <a href="{{url('admin/products/add')}}">Yeni Ürün Ekle</a></li>
                        <li> <a href="{{url('admin/productButton')}}">Ürün ve Stok Butonları</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)">Ürün Özellikleri<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/attributeGroups')}}">Özellik Grupları</a></li>
                        <li> <a href="{{url('admin/attributes')}}">Özellikler</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)">Tanımlar<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/brands')}}">Markalar</a></li>
                    </ul>
                </li>
                <li><a href="{{url('admin/variants')}}">Varyant Sistemi</a></li>
                <li><a href="javascript:void(0)">Vitrin Ve Ürün Düzeni<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/sortHome')}}">Anasayfa Vitrin Düzeni</a></li>
                        <li> <a href="{{url('admin/sortPopular')}}">Popüler Ürünler Vitrin Düzeni</a></li>
                        <li> <a href="{{url('admin/sortCategori')}}">Kategori Vitrin Düzeni</a></li>
                        <li> <a href="{{url('admin/sortBrand')}}">Marka Vitrin Düzeni</a></li>
                        <li> <a href="{{url('admin/sortNew')}}">Yeni Ürünler Vitrin Düzeni</a></li>
                        <li> <a href="{{url('admin/sortSponsor')}}">Sponsor Ürünler Vitrin Düzeni</a></li>
                        <li> <a href="{{url('admin/sortDiscount')}}">İndirimli Ürünler Vitrin Düzeni</a></li>
                    </ul>
                </li>
                <li><a href="{{url('admin/stockWarnings')}}">Ürün Haber Listesi</a></li>
                <li><a href="{{url('admin/bulkOperations')}}">Çoklu Ürün Güncelleme</a></li>
            </ul>
        </li>
            @endpermission
            @permission('category_read')
        <li>
            <a href="{{url('admin/categories')}}" class="waves-effect {{Request::segment(2) == "categories" ? "active" : "" }}">
                <i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i>
                <span class="hide-menu">
                    Kategoriler
                    <span class="fa arrow"></span>
                </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/categories')}}">Kategoriler</a></li>
                <li><a href="{{url('admin/categories/add')}}">Yeni Kategori Ekle</a></li>
            </ul>
        </li>
            @endpermission
            @permission('customer_read')
        <li>
            <a href="{{url('admin/customers')}}" class="waves-effect {{Request::segment(2) == "customers" ? "active" : "" }}">
                <i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i>
            <span class="hide-menu">
                Müşteriler
                <span class="fa arrow"></span>
            </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/customers')}}">Müşteriler</a></li>
                <li><a href="{{url('admin/customerGroups')}}">Müşteri Grupları</a></li>
                <li><a href="{{ route('admin.comments.index') }}">Müşteri Yorumları</a></li>
            </ul>
        </li>
            @endpermission
            @permission('order_read')
        <li>
            @if(Session::has('newOrder') && Session::get('newOrder') > 0 )
                <span class="orderNotification">{{Session::get('newOrder')}}</span>
            @endif

            <a href="{{url('admin/orders')}}" class="waves-effect {{Request::segment(2) == "orders" || Request::segment(2) == "shippingCompanies" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
            <span class="hide-menu">
                Siparişler
                <span class="fa arrow"></span>
            </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="javascript:void(0)">Sipariş Yönetimi<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/orders')}}">Siparişler</a></li>
                        <li> <a href="{{url('admin/refundRequests')}}">İptal ve İade Talepleri</a></li>
                        <li> <a href="{{url('admin/failedOrders')}}">Hatalı Ödemeler</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)">Kargo Yönetimi<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/shippingCompanies')}}">Kargo Firmaları</a></li>
                        <li> <a href="{{url('admin/shippingRoles')}}">Kargo Rolleri</a></li>
                        <li> <a href="{{url('admin/shippingIntegrations')}}">Kargo Entegrasyon</a></li>
                    </ul>
                </li>
            </ul>
        </li>
            @endpermission
            @permission('campaign_read')
        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "campaigns" ? "active" : "" }}">
                <i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i>
        <span class="hide-menu">
            Kampanyalar
            <span class="fa arrow"></span>
        </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/campaigns/coupons')}}">Kupon Kodları</a></li>
                <li><a href="{{url('admin/campaigns/promotion')}}">Promosyonlar</a></li>
            </ul>
        </li>
            @endpermission
            @permission('content_read')
        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "pages" ? "active" : "" }}">
                <i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i>
        <span class="hide-menu">
            İçerik Yönetimi
            <span class="fa arrow"></span>
        </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="javascript:void(0)">Blog Yönetimi<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li><a href="{{url('admin/blog-categories/')}}">Kategori</a></li>
                        <li><a href="{{url('admin/articles')}}">Makale</a></li>
                    </ul>
                </li>
                <li><a href="{{url('admin/pages')}}">Sayfalar</a></li>
                <li><a href="{{url('admin/reviews')}}">Ürün Yorumları</a></li>
            </ul>
        </li>
            @endpermission
        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "countries" ? "active" : "" }}">
                <i data-icon="7" class="linea-icon linea-basic fa-fw text-danger"></i>
                <span class="hide-menu">
                    Yerelleştirme
                    <span class="fa arrow"></span>
                </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/countries')}}">Ülkeler</a></li>
            </ul>
        </li>

        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "bulkOperations" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
            <span class="hide-menu">
                Araçlar
                <span class="fa arrow"></span>
            </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="javascript:void(0)">Mail Yönetimi<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li><a href="{{url('admin/mail/groupList/')}}">Mail Listesi Grupları</a></li>
                        <li><a href="{{url('admin/mail/maillist')}}">Mail Listesi Yönetimi</a></li>
                    </ul>
                </li>
                <li><a href="{{url('admin/redirection')}}">Adres Yönlendirme</a></li>
            </ul>
        </li>

        @permission('settings_edit')
        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "settings" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
        <span class="hide-menu">
            Ayarlar
            <span class="fa arrow"></span>
        </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="javascript:void(0)">Genel Ayarlar<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/settings/basic')}}">Temel Ayarlar</a></li>
                        <li> <a href="{{url('admin/settings/sliders')}}">Slider Yönetimi</a></li>
                        <li> <a href="{{url('admin/settings/popup')}}">Popup Yönetimi</a></li>
                        <li> <a href="{{url('admin/settings/banner')}}">Banner Yönetimi</a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0)">Ödeme Ayarlar<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li> <a href="{{url('admin/settings/banks')}}">Banka Hesapları</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('integration_read')
        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "sdfghj" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
            <span class="hide-menu">
                Entegrasyonlar
                <span class="fa arrow"></span>
            </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/output/list')}}">Çıktı Sistemi</a></li>
                <li><a href="{{url('admin/py/list')}}">Pazaryeri Entegrasyonları</a></li>

            </ul>
        </li>
        @endpermission

        @permission('user_read')
        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "sdfghj" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
        <span class="hide-menu">
            Kullanıcılar
            <span class="fa arrow"></span>
        </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/user')}}">Kullanıcılar</a></li>
                <li><a href="{{url('admin/role')}}">Roller</a></li>
                <li><a href="{{url('admin/processLog')}}">İşlem Kayıtları</a></li>
            </ul>
        </li>
        @endpermission

        <li>
            <a href="#" class="waves-effect {{Request::segment(2) == "stats" ? "active" : "" }}">
                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
                <span class="hide-menu">
                    İstatistikler
                    <span class="fa arrow"></span>
                </span>
            </a>
            <ul class="nav nav-second-level">
                <li><a href="{{url('admin/stats/reports')}}">Raporlar</a></li>
                <li><a href="{{url('admin/stats/orders')}}">Sipariş İstatistikleri</a></li>
                <li><a href="{{url('admin/stats/products')}}">Ürün İstatistikleri</a></li>
                <li><a href="{{url('admin/stats/customers')}}">Üye Sipariş İstatistikleri</a></li>
            </ul>
        </li>
        </ul>
    </div>
</div>
