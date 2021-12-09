@extends('admin.layout.master')
@section('styles')
    <link href="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Yeni Rol Ekle</h4>
                </div>
                <div class="col-lg-2 col-sm-4 col-md-3 col-xs-4 pull-right">
                    <a href="{{url('admin/shippingRoles')}}" class="btn btn-block btn-default btn-rounded">← Roller</a>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-15">Rol Ekle</h3>
                        <form method="post" action="{{url('admin/shippingRoles/create')}}" class="form-horizontal form-bordered">
                            <ul class="nav customtab nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs">Genel Bilgiler</span></a></li>
                                <li role="presentation" class=""><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Oranlar</span></a></li>
                                <li role="presentation" class=""><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Desi Ayarları</span></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab1">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Rol Adı</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_id" class="col-sm-2 control-label">Kargo Firması</label>
                                        <div class="col-sm-10">
                                            <select name="company_id" class="shippingCompany-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-sm-2 control-label">Kullanım Tipi</label>
                                        <div class="col-sm-2">
                                            <select name="type" id="type" class="selectpicker show-tick bs-select-hidden" data-style="form-control" data-width="100%">
                                                <option value="1">Bölge</option>
                                                <option value="2">Ülke</option>
                                                <option value="3">Şehir</option>
                                                <option value="4">İlçe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_1" style="display: none;">
                                        <label for="regions" class="col-sm-2 control-label">Bölgeler</label>
                                        <div class="col-sm-10">
                                            <select name="regions[]" id="regions" multiple="" class="regions-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_2" style="">
                                        <label for="countries" class="col-sm-2 control-label">Ülkeler</label>
                                        <div class="col-sm-10">
                                            <select name="countries[]" id="countries" multiple="" class="country-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_3" style="">
                                        <label for="cities" class="col-sm-2 control-label">Şehirler</label>
                                        <div class="col-sm-10">
                                            <select name="cities[]" id="cities" multiple="" class="cities-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="type_4" style="display:none">
                                        <label for="districts" class="col-sm-2 control-label">İlçeler</label>
                                        <div class="col-sm-10">
                                            <select name="districts[]" id="districts" multiple="" class="districts-ajax js-states form-control select2-hidden-accessible" tabindex="-1" style="display: none; width: 100%" aria-hidden="true">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab2">
                                    <div class="form-group">
                                        <label for="weight_price" class="col-sm-2 control-label">+1 Desi Ücreti</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="weight_price" id="weight_price" value="">
                                    <span class="help-block">
                                        Kargo firması için girmiş olduğunuz desi bilgileri 50 Desiye kadar girilebilmektedir. 50'nin üzeri veya girmiş olduğunuz desi miktarının üzerine her +1 desi için eklenecek olan kargo ücreti
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fixed_price" class="col-sm-2 control-label">Sabit Ücret</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="fixed_price" id="fixed_price" value="">
                                    <span class="help-block">
                                        Sabit bir kargo ücreti uygulayacaksanız her sipariş için sabit kargo ücreti girebilirsiniz. Desi bilgilerini kaydetmeniz durumunda desi toplamlarının üzerine sabit ücret eklenecektir.
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="free_shipping" class="col-sm-2 control-label">Ücretsiz Kargo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="free_shipping" id="free_shipping" value="">
                                    <span class="help-block">
                                        Alışveriş sepeti toplamı belirlediğiniz Ücretsiz kargo limitini geçtiğinde müşterileriniz ücretsiz kargo hizmetinden faydalanabilirler.<b style="color:red">(Örn: X Lira üzeri ücretsiz Kargo!)</b>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="weight_limit" class="col-sm-2 control-label">Ücretsiz Desi Limiti</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="weight_limit" id="weight_limit" value="">
                                            <span class="help-block">Ücretsiz kargo miktarı için maksimum ücretsiz desi miktarıdır. Alışveriş sırasındaki desi miktarı ücretsiz desi miktarından fazlaysa, + Desi miktarını sipariş sırasında sistem müşteriden tahsil eder.<b style="color:red">(Örn: X TL üzeri ücretsiz kargo! Fakat X desiye kadar)</b> Üzeri müşteriden tahsil edilir.</span>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab3">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th width="10%">Desi</th>
                                                <th>Fiyat</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>0-1</td>
                                                <td><input type="text" class="form-control" name="oranlar[0]"></td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td><input type="text" class="form-control" name="oranlar[1]"></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><input type="text" class="form-control" name="oranlar[2]"></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><input type="text" class="form-control" name="oranlar[3]"></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><input type="text" class="form-control" name="oranlar[4]"></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td><input type="text" class="form-control" name="oranlar[5]"></td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td><input type="text" class="form-control" name="oranlar[6]"></td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td><input type="text" class="form-control" name="oranlar[7]"></td>
                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td><input type="text" class="form-control" name="oranlar[8]"></td>
                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td><input type="text" class="form-control" name="oranlar[9]"></td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td><input type="text" class="form-control" name="oranlar[10]"></td>
                                            </tr>
                                            <tr>
                                                <td>11</td>
                                                <td><input type="text" class="form-control" name="oranlar[11]"></td>
                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td><input type="text" class="form-control" name="oranlar[12]"></td>
                                            </tr>
                                            <tr>
                                                <td>13</td>
                                                <td><input type="text" class="form-control" name="oranlar[13]"></td>
                                            </tr>
                                            <tr>
                                                <td>14</td>
                                                <td><input type="text" class="form-control" name="oranlar[14]"></td>
                                            </tr>
                                            <tr>
                                                <td>15</td>
                                                <td><input type="text" class="form-control" name="oranlar[15]"></td>
                                            </tr>
                                            <tr>
                                                <td>16</td>
                                                <td><input type="text" class="form-control" name="oranlar[16]"></td>
                                            </tr>
                                            <tr>
                                                <td>17</td>
                                                <td><input type="text" class="form-control" name="oranlar[17]"></td>
                                            </tr>
                                            <tr>
                                                <td>18</td>
                                                <td><input type="text" class="form-control" name="oranlar[18]"></td>
                                            </tr>
                                            <tr>
                                                <td>19</td>
                                                <td><input type="text" class="form-control" name="oranlar[19]"></td>
                                            </tr>
                                            <tr>
                                                <td>20</td>
                                                <td><input type="text" class="form-control" name="oranlar[20]"></td>
                                            </tr>
                                            <tr>
                                                <td>21</td>
                                                <td><input type="text" class="form-control" name="oranlar[21]"></td>
                                            </tr>
                                            <tr>
                                                <td>22</td>
                                                <td><input type="text" class="form-control" name="oranlar[22]"></td>
                                            </tr>
                                            <tr>
                                                <td>23</td>
                                                <td><input type="text" class="form-control" name="oranlar[23]"></td>
                                            </tr>
                                            <tr>
                                                <td>24</td>
                                                <td><input type="text" class="form-control" name="oranlar[24]"></td>
                                            </tr>
                                            <tr>
                                                <td>25</td>
                                                <td><input type="text" class="form-control" name="oranlar[25]"></td>
                                            </tr>
                                            <tr>
                                                <td>26</td>
                                                <td><input type="text" class="form-control" name="oranlar[26]"></td>
                                            </tr>
                                            <tr>
                                                <td>27</td>
                                                <td><input type="text" class="form-control" name="oranlar[27]"></td>
                                            </tr>
                                            <tr>
                                                <td>28</td>
                                                <td><input type="text" class="form-control" name="oranlar[28]"></td>
                                            </tr>
                                            <tr>
                                                <td>29</td>
                                                <td><input type="text" class="form-control" name="oranlar[29]"></td>
                                            </tr>
                                            <tr>
                                                <td>30</td>
                                                <td><input type="text" class="form-control" name="oranlar[30]"></td>
                                            </tr>
                                            <tr>
                                                <td>31</td>
                                                <td><input type="text" class="form-control" name="oranlar[31]"></td>
                                            </tr>
                                            <tr>
                                                <td>32</td>
                                                <td><input type="text" class="form-control" name="oranlar[32]"></td>
                                            </tr>
                                            <tr>
                                                <td>33</td>
                                                <td><input type="text" class="form-control" name="oranlar[33]"></td>
                                            </tr>
                                            <tr>
                                                <td>34</td>
                                                <td><input type="text" class="form-control" name="oranlar[34]"></td>
                                            </tr>
                                            <tr>
                                                <td>35</td>
                                                <td><input type="text" class="form-control" name="oranlar[35]"></td>
                                            </tr>
                                            <tr>
                                                <td>36</td>
                                                <td><input type="text" class="form-control" name="oranlar[36]"></td>
                                            </tr>
                                            <tr>
                                                <td>37</td>
                                                <td><input type="text" class="form-control" name="oranlar[37]"></td>
                                            </tr>
                                            <tr>
                                                <td>38</td>
                                                <td><input type="text" class="form-control" name="oranlar[38]"></td>
                                            </tr>
                                            <tr>
                                                <td>39</td>
                                                <td><input type="text" class="form-control" name="oranlar[39]"></td>
                                            </tr>
                                            <tr>
                                                <td>40</td>
                                                <td><input type="text" class="form-control" name="oranlar[40]"></td>
                                            </tr>
                                            <tr>
                                                <td>41</td>
                                                <td><input type="text" class="form-control" name="oranlar[41]"></td>
                                            </tr>
                                            <tr>
                                                <td>42</td>
                                                <td><input type="text" class="form-control" name="oranlar[42]"></td>
                                            </tr>
                                            <tr>
                                                <td>43</td>
                                                <td><input type="text" class="form-control" name="oranlar[43]"></td>
                                            </tr>
                                            <tr>
                                                <td>44</td>
                                                <td><input type="text" class="form-control" name="oranlar[44]"></td>
                                            </tr>
                                            <tr>
                                                <td>45</td>
                                                <td><input type="text" class="form-control" name="oranlar[45]"></td>
                                            </tr>
                                            <tr>
                                                <td>46</td>
                                                <td><input type="text" class="form-control" name="oranlar[46]"></td>
                                            </tr>
                                            <tr>
                                                <td>47</td>
                                                <td><input type="text" class="form-control" name="oranlar[47]"></td>
                                            </tr>
                                            <tr>
                                                <td>48</td>
                                                <td><input type="text" class="form-control" name="oranlar[48]"></td>
                                            </tr>
                                            <tr>
                                                <td>49</td>
                                                <td><input type="text" class="form-control" name="oranlar[49]"></td>
                                            </tr>
                                            <tr>
                                                <td>50</td>
                                                <td><input type="text" class="form-control" name="oranlar[50]"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Gönder</button>
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
    <script src="{{asset('src/admin/plugins/bower_components/holdOn/HoldOn.min.js')}}"></script>
    <script>

        $( document ).ready(function() {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            $("#type").on('change', function () {
                var value = $(this).val();
                if(value == 1){
                    $("#type_1").show();
                    $("#type_2").hide();
                    $("#type_3").hide();
                    $("#type_4").hide();
                }else if(value == 2){
                    $("#type_1").hide();
                    $("#type_2").show();
                    $("#type_3").hide();
                    $("#type_4").hide();
                }else if(value == 3){
                    $("#type_1").hide();
                    $("#type_2").show();
                    $("#type_3").show();
                    $("#type_4").hide();
                }else if(value == 4){
                    $("#type_1").hide();
                    $("#type_2").show();
                    $("#type_3").show();
                    $("#type_4").show();
                }
            });

            // Shipping Company Ajax
            $(".shippingCompany-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/shippingCompanies/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Kargo Firması Seçiniz'
            });

            // Regions Ajax
            $(".regions-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/regions/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Bölge Seçiniz'
            });

            // Countries Ajax
            $(".country-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/countries/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Ülke Seçiniz'
            });

            // Cities Ajax
            $(".cities-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/cities/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            country_id:$('#countries').val()
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Şehir Seçiniz'
            });

            // Districts Ajax
            $(".districts-ajax").select2({
                language: "tr",
                ajax: {
                    url: "{{url('admin/districts/ajax/list')}}",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            city_id:$('#cities').val()
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function(item) {
                                return { id: item.id, text: item.name };
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'İlçe Seçiniz'
            });
        });

    </script>
@endsection