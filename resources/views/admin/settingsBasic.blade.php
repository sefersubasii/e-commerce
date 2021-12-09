@extends('admin.layout.master')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Temel Ayarlar</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <?php /*
                    <a href="#" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                        Buy Now
                    </a>
                    */ ?>

                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Temel Ayarlar</h3>
                        <form autocomplete="off" method="post" action="{{url('admin/settings/basic/update')}}" enctype="multipart/form-data" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Genel Bilgiler</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Firma Bilgileri</span></a></li>
                                <li role="presentation" class=""><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">E-Mail Ayarları</span></a></li>
                                <li role="presentation" class=""><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">SEO Ayarları</span></a></li>
                                <li role="presentation" class=""><a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">SMS Ayarları</span></a></li>
                                <li role="presentation" class=""><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Sosyal Medya</span></a></li>
                                <li role="presentation" class=""><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Tanımlamalar</span></a></li>
                                <li role="presentation" class=""><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Önbellek (cache)</span></a></li>
                                <li role="presentation" class=""><a href="#tab9" aria-controls="tab9" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">İndirim Geçerlilik Tarihleri</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="input-file-now" class="col-sm-2 control-label">Site Logo</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="logo_url" data-default-file="{{asset('src/uploads/settings/'.@json_decode($data->basic)->logo)}}" id="input-file-now" class="dropify" data-default-file="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="site_copyright" class="col-sm-2 control-label">Copyright</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->basic)->copyright}}" name="site_copyright" id="site_copyright">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="maintenance_status" class="col-sm-2 control-label">Bakım Modu</label>
                                        <div class="col-sm-2">
                                            <select name="maintenance_status" id="maintenance_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{@json_decode($data->basic)->maintenance_status == 1 ? "selected='selected'" : ""}} value="1">Aktif</option>
                                                <option {{@json_decode($data->basic)->maintenance_status == 0 ? "selected='selected'" : ""}} value="0" selected="">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="maintenance_text" class="col-sm-2 control-label">Bakım Mesajı</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor"  name="content" style="height: 140px;">{{@json_decode($data->basic)->maintenance_content}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="article" class="col-sm-2 control-label"> Anasayfa Makalesi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor" name="article" style="height: 140px;">{{@json_decode($data->basic)->article}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <label for="company_name" class="col-sm-2 control-label">Firma Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_name}}" name="company_name" id="company_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_short_name" class="col-sm-2 control-label">Firma Kısa Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_short_name}}" name="company_short_name" id="company_short_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_contact" class="col-sm-2 control-label">Yetkili Kişi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_contact}}" name="company_contact" id="company_contact">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address" class="col-sm-2 control-label">Firma Adresi</label>
                                        <div class="col-sm-10">
                                            <textarea name="company_address" id="company_address" class="form-control">{{@json_decode($data->company)->company_address}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_logistics" class="col-sm-2 control-label">Lojistik Depo Adresi</label>
                                        <div class="col-sm-10">
                                            <textarea name="company_logistics" id="company_logistics" class="form-control">{{@json_decode($data->company)->company_logistics}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_city" class="col-sm-2 control-label">Şehir</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_city}}" name="company_city" id="company_city">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_district" class="col-sm-2 control-label">Semt</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_district}}" name="company_district" id="company_district">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_zip_code" class="col-sm-2 control-label">Posta Kodu</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_zip_code}}" name="company_zip_code" id="company_zip_code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_tax_office" class="col-sm-2 control-label">Vergi Dairesi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_tax_office}}" name="company_tax_office" id="company_tax_office">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_tax_id" class="col-sm-2 control-label">Vergi No</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_tax_id}}" name="company_tax_id" id="company_tax_id">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_phone" class="col-sm-2 control-label">Telefon</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_phone}}" name="company_phone" id="company_phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_fax" class="col-sm-2 control-label">Fax</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_fax}}" name="company_fax" id="company_fax">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_email" class="col-sm-2 control-label">E-Posta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->company)->company_email}}" name="company_email" id="company_email">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab3">
                                    <div class="form-group">
                                        <label for="mail_status" class="col-sm-2 control-label">Durum</label>
                                        <div class="col-sm-2">
                                            <select name="mail_status" id="mail_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{@json_decode($data->mail)->mail_status == 1 ? "selected='selected'" : "" }} value="1">Aktif</option>
                                                <option {{@json_decode($data->mail)->mail_status == 0 ? "selected='selected'" : "" }} value="0">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_from_name" class="col-sm-2 control-label">Gönderenin Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->mail)->mail_from_name}}" name="mail_from_name" id="mail_from_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_from_email" class="col-sm-2 control-label">Gönderenin Mail</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->mail)->mail_from_email}}" name="mail_from_email" id="mail_from_email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_host" class="col-sm-2 control-label">Host</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->mail)->mail_host}}" name="mail_host" id="mail_host">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_username" class="col-sm-2 control-label">Kullanıcı Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->mail)->mail_username}}" name="mail_username" id="mail_username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_password" class="col-sm-2 control-label">Şifre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->mail)->mail_password}}" name="mail_password" id="mail_password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_port" class="col-sm-2 control-label">Port</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->mail)->mail_port}}" name="mail_port" id="mail_port">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail_encryption" class="col-sm-2 control-label">Güvenlik</label>
                                        <div class="col-sm-2">
                                            <select name="mail_encryption" id="mail_encryption" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{@json_decode($data->mail)->mail_encryption == "" ? "selected='selected'" : "" }} value="">Hiçbiri</option>
                                                <option {{@json_decode($data->mail)->mail_encryption == "ssl" ? "selected='selected'" : "" }} value="ssl" selected="">SSL</option>
                                                <option {{@json_decode($data->mail)->mail_encryption == "tls" ? "selected='selected'" : "" }} value="tls">TLS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab4">
                                    <div class="form-group">
                                        <label for="seo_title" class="col-sm-2 control-label">Site Başlığı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->seo)->seo_title}}" name="seo_title" id="seo_title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_description" class="col-sm-2 control-label">Site Açıklaması</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->seo)->seo_description}}" name="seo_description" id="seo_description">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_keywords" class="col-sm-2 control-label">Anahtar Kelimeler</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->seo)->seo_keywords}}" name="seo_keywords" id="seo_keywords">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_verification_code" class="col-sm-2 control-label">Site Doğrulama Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_verification_code" id="seo_verification_code" class="form-control">{{@json_decode($data->seo)->seo_verification_code}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_kenshoo_global" class="col-sm-2 control-label">Kenshoo Global</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_kenshoo_global" id="seo_kenshoo_global" class="form-control" style="margin: 0px; width: 1087px; height: 54px;">{{@json_decode($data->seo)->seo_kenshoo_global}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_global_code_ads" class="col-sm-2 control-label">Global site tag - Google Ads</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_global_code_ads" id="seo_global_code_ads" class="form-control" style="margin: 0px; width: 1087px; height: 54px;">{{@json_decode($data->seo)->seo_global_code_ads}}</textarea>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label for="seo_tracking_code" class="col-sm-2 control-label">Analytics İzleme Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_tracking_code" id="seo_tracking_code" class="form-control" style="margin: 0px; width: 1087px; height: 54px;">{{@json_decode($data->seo)->seo_tracking_code}}</textarea>
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label for="seo_yandex_metrika" class="col-sm-2 control-label">Yandex Metrika Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_yandex_metrika" id="seo_yandex_metrika" class="form-control" style="margin: 0px; width: 1087px; height: 54px;">{{@json_decode($data->seo)->seo_yandex_metrika}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_live_support" class="col-sm-2 control-label">Canlı Destek Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_live_support" id="seo_live_support" class="form-control" style="margin: 0px; height: 54px; width: 1094px;">{{@json_decode($data->seo)->seo_live_support}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="seo_remarketing_code" class="col-sm-2 control-label">Yeniden Pazarlama Kodu</label>
                                        <div class="col-sm-10">
                                            <textarea name="seo_remarketing_code" id="seo_remarketing_code" class="form-control" style="margin: 0px; width: 1095px; height: 54px;">{{@json_decode($data->seo)->seo_remarketing_code}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab5">
                                    <div class="form-group">
                                        <label for="sms_status" class="col-sm-2 control-label">SMS Durumu</label>
                                        <div class="col-sm-2">
                                            <select name="sms_status" id="sms_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{@json_decode($data->sms)->sms_status == 1 ? "selected='selected'" : ""}} value="1">Aktif</option>
                                                <option {{@json_decode($data->sms)->sms_status == 0 ? "selected='selected'" : ""}} value="0">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sms_platform" class="col-sm-2 control-label">SMS Firması</label>
                                        <div class="col-sm-2">
                                            <select name="sms_platform" id="sms_platform" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option {{@json_decode($data->sms)->sms_platform == "NetGsm" ? "selected='selected'" : ""}} value="NetGsm" selected="">Net GSM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sms_sender" class="col-sm-2 control-label">Başlık</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->sms)->sms_sender}}" name="sms_sender" id="sms_sender">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sms_username" class="col-sm-2 control-label">Kullanıcı Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" autocomplete="off" class="form-control" value="{{@json_decode($data->sms)->sms_username}}" name="sms_username" id="sms_username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sms_password" class="col-sm-2 control-label">Şifre</label>
                                        <div class="col-sm-10">
                                            <input type="password" autocomplete="off" class="form-control" value="{{@json_decode($data->sms)->sms_password}}" name="sms_password" id="sms_password">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab6">
                                    <h3 class="box-title">Facebook</h3>
                                    <div class="form-group">
                                        <label for="facebook_link" class="col-sm-2 control-label">Facebook Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->facebook->facebook_link}}" name="facebook_link" id="facebook_link">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="facebook_client_id" class="col-sm-2 control-label">Facebook Client ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->facebook->facebook_client_id}}" name="facebook_client_id" id="facebook_client_id">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="facebook_client_secret" class="col-sm-2 control-label">Facebook Client Secret</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->facebook->facebook_client_secret}}" name="facebook_client_secret" id="facebook_client_secret">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="facebook_redirect" class="col-sm-2 control-label">Facebook Redirect</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->facebook->facebook_redirect}}" name="facebook_redirect" id="facebook_redirect">
                                        </div>
                                    </div>
                                    <h3 class="box-title">Twitter</h3>
                                    <div class="form-group">
                                        <label for="twitter_link" class="col-sm-2 control-label">Twitter Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->twitter->twitter_link}}" name="twitter_link" id="twitter_link">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter_client_id" class="col-sm-2 control-label">Twitter Client ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->twitter->twitter_client_id}}" name="twitter_client_id" id="twitter_client_id">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter_client_secret" class="col-sm-2 control-label">Twitter Client Secret</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->twitter->twitter_client_secret}}" name="twitter_client_secret" id="twitter_client_secret">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="twitter_redirect" class="col-sm-2 control-label">Twitter Redirect</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->twitter->twitter_redirect}}" name="twitter_redirect" id="twitter_redirect">
                                        </div>
                                    </div>
                                    <h3 class="box-title">Google+</h3>
                                    <div class="form-group">
                                        <label for="google_link" class="col-sm-2 control-label">Google+ Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->google->google_link}}" name="google_link" id="google_link">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="google_client_id" class="col-sm-2 control-label">Google+ Client ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->google->google_client_id}}" name="google_client_id" id="google_client_id">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="google_client_secret" class="col-sm-2 control-label">Google+ Client Secret</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->google->google_client_secret}}" name="google_client_secret" id="google_client_secret">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="google_redirect" class="col-sm-2 control-label">Google+ Redirect</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->google->google_redirect}}" name="google_redirect" id="google_redirect">
                                        </div>
                                    </div>

                                    <h3 class="box-title">Youtube</h3>
                                    <div class="form-group">
                                        <label for="youtube_link" class="col-sm-2 control-label">Youtube Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->youtube->youtube_link}}" name="youtube_link" id="youtube_link">
                                        </div>
                                    </div>

                                    <h3 class="box-title">Instagram</h3>
                                    <div class="form-group">
                                        <label for="instagram_link" class="col-sm-2 control-label">İnstagram Link</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{@json_decode($data->social)->instagram->instagram_link}}" name="instagram_link" id="instagram_link">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab7">
                                     <div class="form-group" style="display:none">
                                        <label for="notificationform" class="col-sm-2 control-label">Ön bilgilendirme formu</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor"  name="notificationform" style="height: 140px;">{{@json_decode($data->constants)->notificationform}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="useragreement" class="col-sm-2 control-label">Üyelik Sözleşmesi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor"  name="useragreement" style="height: 140px;">{{@json_decode($data->constants)->useragreement}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="paymentagreement" class="col-sm-2 control-label">Satış Sözleşmesi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control editor"  name="paymentagreement" style="height: 140px;">{{@json_decode($data->constants)->paymentagreement}}</textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab8">
                                     <div class="form-group">
                                        <label for="notificationform" class="col-sm-2 control-label">Önbelleği Temizle</label>
                                        <div class="col-sm-10">
                                            <a href="{{url('admin/cache/clear')}}" type="button" class="btn btn-primary">Temizle</a>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab9">
                                        <div class="form-group">
                                            <label for="discountdate_status" class="col-sm-2 control-label">Durum</label>
                                            <div class="col-sm-8">
                                                <select name="discountdate_status" id="discountdate_status" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                    <option {{@json_decode($data->basic)->discountdate_status == 1 ? "selected='selected'" : "" }} value="1">Aktif</option>
                                                    <option {{@json_decode($data->basic)->discountdate_status == 0 ? "selected='selected'" : "" }} value="0">Pasif</option>
                                                </select>
                                                <span class="help-block">İndirim geçerlilik tarihleri ürün eklenirken belirlenir. O tarihler arasında ürün indirime girer. Tarihi biterse ürün normal fiyatına döner</span>
                                                {!! @json_decode($data->basic)->discountdate_status == 0 ? '<span  style="color:red!important;font-weight:bold;"   class="help-block">Aktif hale getirdikten sonra lütfen önbelleği temizleyiniz..</span>' : "" !!}
                                                {!! @json_decode($data->basic)->discountdate_status == 1 ? '<span  style="color:red!important;font-weight:bold;"   class="help-block">Pasif hale getirdikten sonra lütfen önbelleği temizleyiniz..</span>' : "" !!}


                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Güncelle</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('src/admin/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $( document ).ready(function() {
            $('.dropify').dropify({
                messages: {
                    'default': 'Resim seçmek için sürükleyip bırakın veya tıklayın.',
                    'replace': 'Değiştirmek için tıklayın veya bir dosya sürükleyin.',
                    'remove':  'Kaldır',
                    'error':   'Bir hata oluştu.'
                }
            });
        });

    </script>
@endsection

