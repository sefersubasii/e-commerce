<!DOCTYPE html>
<html style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">
<head style="box-sizing: border-box;">
    <meta charset="utf-8" style="box-sizing: border-box;">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" style="box-sizing: border-box;">
    <title style="box-sizing: border-box;">Toptan İstek Formu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" style="box-sizing: border-box;">
</head>

<body style="box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #fff;min-width: 992px!important;">
    <div class="container" style="max-width: 704px;box-sizing: border-box;width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;min-width: 992px!important;">
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <div class="col-md-12" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
                <h1 class="text-center text-primary" style="margin-top: 23px;box-sizing: border-box;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 2.5rem;text-align: center!important;color: #007bff!important;">Toptan Fiyat istek Formu</h1>
                {{-- <hr style="box-sizing: content-box;height: 0;overflow: visible;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0,0,0,.1);"> --}}
            </div>
        </div>
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <div class="col" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex-preferred-size: 0;flex-basis: 0;-ms-flex-positive: 1;flex-grow: 1;max-width: 100%;">
                <div class="table-responsive" style="box-sizing: border-box;display: block;width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;">
                    <table class="table table-sm" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;">
                        <thead style="box-sizing: border-box;display: table-header-group;">
                            <tr style="box-sizing: border-box;page-break-inside: avoid;">
                                <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">AD SOYAD</th>
                                <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">TELEFON</th>
                                <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">ADET</th>
                            </tr>
                        </thead>
                        <tbody style="box-sizing: border-box;">
                            <tr style="box-sizing: border-box;page-break-inside: avoid;">
                                <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">{{ $form->name }}</td>
                                <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">{{ $form->phone }}</td>
                                <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">{{ $form->quantity }}</td>
                            </tr>
                            <tr style="box-sizing: border-box;page-break-inside: avoid;"></tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive" style="box-sizing: border-box;display: block;width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;">
                    <table class="table table-sm" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;">
                        <thead style="box-sizing: border-box;display: table-header-group;">
                            <tr style="box-sizing: border-box;page-break-inside: avoid;">
                                <th style="width: 133px;box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">ÜRÜN ID</th>
                                <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">ÜRÜN ADI</th>
                            </tr>
                        </thead>
                        <tbody style="box-sizing: border-box;">
                            <tr style="box-sizing: border-box;page-break-inside: avoid;">
                                <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">{{ $product->id }}</td>
                                <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">{{ $product->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr style="box-sizing: content-box;height: 0;overflow: visible;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0,0,0,.1);">
                <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
                    <div class="col text-center" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex-preferred-size: 0;flex-basis: 0;-ms-flex-positive: 1;flex-grow: 1;max-width: 100%;text-align: center!important;"><a class="btn btn-primary text-white" role="button" href="{{ $productUrl }}" style="box-sizing: border-box;color: #fff!important;text-decoration: none;background-color: #007bff;display: inline-block;font-weight: 400;text-align: center;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent;padding: .375rem .75rem;font-size: 1rem;line-height: 1.5;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;border-color: #007bff;">Ürün Sayfasına Git</a></div>
                </div>
            </div>
        </div>
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <div class="col text-center" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex-preferred-size: 0;flex-basis: 0;-ms-flex-positive: 1;flex-grow: 1;max-width: 100%;text-align: center!important;">
                <hr style="box-sizing: content-box;height: 0;overflow: visible;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0,0,0,.1);">
            </div>
        </div>
        <footer class="text-center" style="box-sizing: border-box;display: block;text-align: center!important;"><a href="https://marketpaketi.com.tr" target="_blank" style="box-sizing: border-box;color: #007bff;text-decoration: underline;background-color: transparent;">www.marketpaketi.com.tr</a></footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" style="box-sizing: border-box;"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js" style="box-sizing: border-box;"></script>
</body>

</html>