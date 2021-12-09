<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Popup;
use App\Banner;
use App\Slider;
use App\Categori;
use App\SliderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\App;
use Mockery\CountValidator\Exception;

class SettingsBasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:settings_edit');
    }

    public function index()
    {
        $data = \App\Settings_basic::find(1);
        return view('admin.settingsBasic', compact("data"));
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $basic = [
            "copyright"           => $request->get("site_copyright"),
            "maintenance_status"  => $request->get("maintenance_status"),
            "maintenance_content" => $request->get("content"),
            "article"             => $request->get("article"),
            'discountdate_status' => $request->get("discountdate_status"),
        ];
        $company = [
            "company_name"       => $request->get("company_name"),
            "company_short_name" => $request->get("company_short_name"),
            "company_contact"    => $request->get("company_contact"),
            "company_address"    => $request->get("company_address"),
            "company_logistics"  => $request->get("company_logistics"),
            "company_city"       => $request->get("company_city"),
            "company_district"   => $request->get("company_district"),
            "company_zip_code"   => $request->get("company_zip_code"),
            "company_tax_office" => $request->get("company_tax_office"),
            "company_tax_id"     => $request->get("company_tax_id"),
            "company_phone"      => $request->get("company_phone"),
            "company_fax"        => $request->get("company_fax"),
            "company_email"      => $request->get("company_email"),
        ];
        $mail = [
            "mail_status"     => $request->get("mail_status"),
            "mail_from_name"  => $request->get("mail_from_name"),
            "mail_from_email" => $request->get("mail_from_email"),
            "mail_host"       => $request->get("mail_host"),
            "mail_username"   => $request->get("mail_username"),
            "mail_password"   => $request->get("mail_password"),
            "mail_port"       => $request->get("mail_port"),
            "mail_encryption" => $request->get("mail_encryption"),
        ];

        $seo = [
            "seo_title"             => $request->get("seo_title"),
            "seo_description"       => $request->get("seo_description"),
            "seo_keywords"          => $request->get("seo_keywords"),
            "seo_verification_code" => $request->get("seo_verification_code"),
            "seo_kenshoo_global"    => $request->get("seo_kenshoo_global"),
            "seo_tracking_code"     => $request->get("seo_tracking_code"),
            "seo_global_code_ads"   => $request->get("seo_global_code_ads"),
            "seo_yandex_metrika"    => $request->get("seo_yandex_metrika"),
            "seo_live_support"      => $request->get("seo_live_support"),
            "seo_remarketing_code"  => $request->get("seo_remarketing_code"),
        ];
        $sms = [
            "sms_status"   => $request->get("sms_status"),
            "sms_platform" => $request->get("sms_platform"),
            "sms_sender"   => $request->get("sms_sender"),
            "sms_username" => $request->get("sms_username"),
            "sms_password" => $request->get("sms_password"),
        ];
        $social = [
            "facebook"  => [
                "facebook_link"          => $request->get("facebook_link"),
                "facebook_client_id"     => $request->get("facebook_client_id"),
                "facebook_client_secret" => $request->get("facebook_client_secret"),
                "facebook_redirect"      => $request->get("facebook_redirect"),
            ],
            "twitter"   => [
                "twitter_link"          => $request->get("twitter_link"),
                "twitter_client_id"     => $request->get("twitter_client_id"),
                "twitter_client_secret" => $request->get("twitter_client_secret"),
                "twitter_redirect"      => $request->get("twitter_redirect"),
            ],
            "google"    => [
                "google_link"          => $request->get("google_link"),
                "google_client_id"     => $request->get("google_client_id"),
                "google_client_secret" => $request->get("google_client_secret"),
                "google_redirect"      => $request->get("google_redirect"),
            ],
            "youtube"   => [
                "youtube_link" => $request->get("youtube_link"),
            ],
            "instagram" => [
                "instagram_link" => $request->get("instagram_link"),
            ],
        ];

        $constants = [
            "notificationform" => $request->get("notificationform"),
            "useragreement"    => $request->get("useragreement"),
            "paymentagreement" => $request->get("paymentagreement"),
        ];

        if ($request->hasFile('logo_url')) {
            $image           = $request->file('logo_url');
            $destinationPath = public_path() . '/src/uploads/settings/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = "logo-" . $microtime[0] . $microtime[1] . "." . $request->file('logo_url')->getClientOriginalExtension();
            $image->move($destinationPath, $filename);
            $basic["logo"] = $filename;

            // old image delete
            $old = \App\Settings_basic::find(1);
            if (!empty(json_decode($old->basic)->logo) && json_decode($old->basic)->logo != $basic["logo"]) {
                $destinationPath = public_path() . '/src/uploads/settings/' . json_decode($old->basic)->logo;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }

        }

        $updateData = [
            "basic"     => json_encode($basic, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            "company"   => json_encode($company, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            "mail"      => json_encode($mail, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            "seo"       => json_encode($seo, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            "sms"       => json_encode($sms, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            "social"    => json_encode($social, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
            "constants" => json_encode($constants, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
        ];

        try {
            \App\Settings_basic::where("id", 1)->update($updateData);
            Session()->flash('status', array(1, "Tebrikler."));
            \LogActivity::addToLog('Temel ayarlar düzenlendi.');
        } catch (Exception $e) {
            \App\Settings_basic::where("id", 1)->update($updateData);
            Session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/basic');

    }

    public function sliders()
    {
        return view('admin.sliders');
    }

    public function slidersDatatable()
    {
        $sliders = \App\Slider::all();
        return Datatables::of($sliders)->make(true);
    }

    public function sliderEdit($id)
    {
        $slider = \App\Slider::find($id);
        return view('admin.sliderEdit', compact('slider'));
    }

    public function sliderUpdate($id, Request $request)
    {
        $slider = \App\Slider::find($id);
        $data   = [
            "description" => $request->get("description"),
            "status"      => $request->get("status"),
        ];

        try {
            $update = \App\Slider::where('id', '=', $id)
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Slider düzenlendi.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/sliders');

    }

    public function sliderItems(Request $request)
    {
        //dd($request->all());
        $id = $request->get("id");
        return view('admin.sliderItems', compact('id'));
    }

    public function sliderItemsDatatable($id)
    {
        $sliderItems = SliderItem::where('slider_id', $id)->orderBy('sort', 'asc')->get();
        return Datatables::of($sliderItems)->make(true);
    }

    public function sliderItemEdit($id)
    {
        $data = SliderItem::find($id);
        return view('admin.sliderItemEdit', compact('data'));
    }

    public function sliderItemAdd(Request $request)
    {
        $id = $request->get("id");
        return view('admin.sliderItemAdd', compact('id'));
    }

    public function sliderItemUpdate($id, Request $request)
    {
        $old = SliderItem::find($id);

        $data = [
            "name"    => $request->get("name"),
            "status"  => $request->get("status"),
            "sort"    => $request->get("sort"),
            "link"    => $request->get("link"),
            "content" => $request->get("content"),
        ];

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/slider/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);

            /* tinypng*/
            /*
            $tiny="";
            $filepath=$destinationPath.$filename;
            try {
            \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
            $source = \Tinify\fromFile($filepath);
            $source->toFile($filepath);
            $tiny="ok";
            } catch(\Tinify\AccountException $e) {
            // Verify your API key and account limit.
            $tiny=$e->getMessage();
            } catch(\Tinify\ClientException $e) {
            // Check your source image and request options.
            $tiny=$e->getMessage();
            } catch(\Tinify\ServerException $e) {
            // Temporary issue with the Tinify API.
            $tiny=$e->getMessage();
            } catch(\Tinify\ConnectionException $e) {
            // A network connection error occurred.
            $tiny=$e->getMessage();
            } catch(Exception $e) {
            // Something else went wrong, unrelated to the Tinify API.
            $tiny=$e->getMessage();
            }
             */
            /* tinypng*/

            $data["image"] = $filename;

            // old image delete
            if (!empty($old->image) && $old->image != $data["image"]) {
                $destinationPath = public_path() . '/src/uploads/slider/' . $old->image;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }

        }

        if ($request->hasFile('imageCover')) {
            $image           = $request->file('imageCover');
            $destinationPath = public_path() . '/src/uploads/slider/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . "-logo-" . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);

            /* tinypng*/
            /*
            $tiny="";
            $filepath=$destinationPath.$filename;
            try {
            \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
            $source = \Tinify\fromFile($filepath);
            $source->toFile($filepath);
            $tiny="ok";
            } catch(\Tinify\AccountException $e) {
            // Verify your API key and account limit.
            $tiny=$e->getMessage();
            } catch(\Tinify\ClientException $e) {
            // Check your source image and request options.
            $tiny=$e->getMessage();
            } catch(\Tinify\ServerException $e) {
            // Temporary issue with the Tinify API.
            $tiny=$e->getMessage();
            } catch(\Tinify\ConnectionException $e) {
            // A network connection error occurred.
            $tiny=$e->getMessage();
            } catch(Exception $e) {
            // Something else went wrong, unrelated to the Tinify API.
            $tiny=$e->getMessage();
            }
             */
            /* tinypng*/

            $data["imageCover"] = $filename;

            // old image delete
            if (!empty($old->imageCover) && $old->imageCover != $data["imageCover"]) {
                $destinationPath = public_path() . '/src/uploads/slider/' . $old->imageCover;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }

        }

        try {
            $update = SliderItem::where('id', '=', $id)
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Slider görseli düzenlendi.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/sliderItem/edit/' . $id);
    }

    public function sliderItemCreate($id, Request $request)
    {
        if ($request->hasFile('image')) {

            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/slider/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            /* tinypng*/
            /*
            $tiny="";
            $filepath=$destinationPath.$filename;
            try {
            \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
            $source = \Tinify\fromFile($filepath);
            $source->toFile($filepath);
            $tiny="ok";
            } catch(\Tinify\AccountException $e) {
            // Verify your API key and account limit.
            $tiny=$e->getMessage();
            } catch(\Tinify\ClientException $e) {
            // Check your source image and request options.
            $tiny=$e->getMessage();
            } catch(\Tinify\ServerException $e) {
            // Temporary issue with the Tinify API.
            $tiny=$e->getMessage();
            } catch(\Tinify\ConnectionException $e) {
            // A network connection error occurred.
            $tiny=$e->getMessage();
            } catch(Exception $e) {
            // Something else went wrong, unrelated to the Tinify API.
            $tiny=$e->getMessage();
            }
             */
            /* tinypng*/

            if ($request->hasFile('imageCover')) {
                $imageCover    = $request->file('imageCover');
                $filenameCover = str_slug($request->get('name')) . "-logo-" . $microtime[0] . $microtime[1] . ".jpg";
                $imageCover->move($destinationPath, $filenameCover);
                /* tinypng*/
                /*
                $tiny="";
                $filepath=$destinationPath.$filenameCover;
                try {
                \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
                $source = \Tinify\fromFile($filepath);
                $source->toFile($filepath);
                $tiny="ok";
                } catch(\Tinify\AccountException $e) {
                // Verify your API key and account limit.
                $tiny=$e->getMessage();
                } catch(\Tinify\ClientException $e) {
                // Check your source image and request options.
                $tiny=$e->getMessage();
                } catch(\Tinify\ServerException $e) {
                // Temporary issue with the Tinify API.
                $tiny=$e->getMessage();
                } catch(\Tinify\ConnectionException $e) {
                // A network connection error occurred.
                $tiny=$e->getMessage();
                } catch(Exception $e) {
                // Something else went wrong, unrelated to the Tinify API.
                $tiny=$e->getMessage();
                }
                 */
                /* tinypng*/
            }

            $data = [
                "slider_id"  => $id,
                "name"       => $request->get("name"),
                "status"     => $request->get("status"),
                "sort"       => $request->get("sort"),
                "link"       => $request->get("link"),
                "content"    => $request->get("content"),
                "image"      => $filename,
                "imageCover" => $request->hasFile('imageCover') ? $filenameCover : null,
            ];
            //dd($data);

            $add = SliderItem::create($data);
            if ($add) {
                $request->session()->flash('status', array(1, "Eklendi."));
                \LogActivity::addToLog('Slider görseli eklendi.');
            } else {
                $request->session()->flash('status', array(0, "Hata Oluştu!"));
            }
        } else {
            $request->session()->flash('status', array(0, "Resim Seçmediniz!"));
        }
        return redirect("admin/settings/sliderItems?id=" . $id);
    }

    public function sliderItemDelete($id)
    {
        $br         = SliderItem::find($id);
        $redirectId = $br->slider_id;

        if (!empty($br->image)) {
            $destinationPath = public_path() . '/src/uploads/slider/' . $br->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        if (!empty($br->imageCover)) {
            $destinationPath = public_path() . '/src/uploads/slider/' . $br->imageCover;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        try {
            $br->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Slider görseli silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/settings/sliderItems?id=" . $redirectId);
    }

    public function popup()
    {
        return view("admin.popup");
    }

    public function popupDatatable()
    {
        $popup = Popup::all();
        return Datatables::of($popup)->make(true);
    }

    public function popupAdd()
    {
        return view("admin.popupAdd");
    }

    public function popupCreate(Request $request)
    {
        $data = [
            "name"       => $request->get("name"),
            "status"     => $request->get("status"),
            "content"    => $request->get("content"),
            "frequency"  => $request->get("frequency") ?: 5,
            "homeStatus" => $request->has("homeStatus"),
            "categories" => null,
        ];

        if ($request->has('category') && $request->has('categories')) {
            $data['categories'] = json_encode($request->get("categories"));
        }

        try {
            Popup::create($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Popup oluşturuldu.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/popup');
    }

    public function popupEdit($id)
    {
        $popup = Popup::find($id);

        $popup->cats = Categori::whereIn("id", $popup->categories)
            ->get("id", "title");

        return view('admin.popupEdit', compact('popup'));
    }

    public function popupUpdate($id, Request $request)
    {
        $pop = Popup::find($id);

        $data = [
            "name"       => $request->get("name"),
            "status"     => $request->get("status"),
            "content"    => $request->get("content"),
            "frequency"  => $request->get("frequency") ?: 5,
            "homeStatus" => $request->has("homeStatus"),
            'categories' => null,
        ];

        if ($request->has('category') && $request->has('categories')) {
            $data['categories'] = json_encode($request->get("categories"));
        }

        try {
            $update = $pop->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Popup düzenlendi.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/popup/edit/' . $id);
    }

    public function popupDelete($id)
    {
        $br = Popup::find($id);
        try {
            $br->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Popup silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/settings/popup");
    }

    public function banner()
    {
        return view('admin.banner');
    }

    public function bannerDatatable()
    {
        $banner = Banner::all();
        return Datatables::of($banner)->make(true);
    }

    public function bannerEdit($id)
    {
        $banner = Banner::find($id);
        return view('admin.bannerEdit', compact('banner'));
    }

    public function bannerUpdate($id, Request $request)
    {
        $pop = Banner::find($id);

        $data = [
            "name"   => $request->get("name"),
            "link"   => $request->get("link"),
            "alt"    => $request->get("alt"),
            "newTab" => $request->has("newTab") ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/banner/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            /* tinypng*/
            $tiny     = "";
            $filepath = $destinationPath . $filename;
            try {
                \Tinify\setKey("woUCwhryS1ejfyxjo6up0G-1DbXeoUvj");
                $source = \Tinify\fromFile($filepath);
                $source->toFile($filepath);
                $tiny = "ok";
            } catch (\Tinify\AccountException $e) {
                // Verify your API key and account limit.
                $tiny = $e->getMessage();
            } catch (\Tinify\ClientException $e) {
                // Check your source image and request options.
                $tiny = $e->getMessage();
            } catch (\Tinify\ServerException $e) {
                // Temporary issue with the Tinify API.
                $tiny = $e->getMessage();
            } catch (\Tinify\ConnectionException $e) {
                // A network connection error occurred.
                $tiny = $e->getMessage();
            } catch (Exception $e) {
                // Something else went wrong, unrelated to the Tinify API.
                $tiny = $e->getMessage();
            }
            /* tinypng*/
            $data["image"] = $filename;

            // old image delete
            if (!empty($pop->image) && $pop->image != $data["image"]) {
                $destinationPath = public_path() . '/src/uploads/banner/' . $pop->image;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }
        }

        try {
            $update = Banner::where("id", $id)
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Banner düzenlendi.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/banner/edit/' . $id);

    }

    public function imageRemove(Request $request)
    {
        $br = Banner::find($request->get('id'));

        $destinationPath = public_path() . '/src/uploads/banner/' . $br->image;
        if (file_exists($destinationPath)) {
            @unlink($destinationPath);
        }
        \LogActivity::addToLog('Banner silindi.');
        $br->image = "";
        $br->save();
        return "true";
    }

    public function banks()
    {
        return view("admin.banks.banks");
    }

    public function banksDatatable()
    {
        $bank = Bank::all();
        return Datatables::of($bank)->make(true);
    }

    public function bankEdit($id)
    {
        $data = Bank::find($id);
        return view('admin.banks.edit', compact('data'));
    }

    public function bankUpdate($id, Request $request)
    {
        $bank = Bank::find($id);

        $data = [
            "name"     => $request->get("name"),
            "owner"    => $request->get("owner"),
            "iban"     => $request->get("iban"),
            "currency" => $request->get("currency"),
            "sort"     => $request->get("sort"),
        ];

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/banks/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;

            // old image delete
            if (!empty($bank->image) && $bank->image != $data["image"]) {
                $destinationPath = public_path() . '/src/uploads/banner/' . $bank->image;
                if (file_exists($destinationPath)) {
                    @unlink($destinationPath);
                }
            }
        }

        try {
            $update = Bank::where("id", $id)
                ->update($data);
            $request->session()->flash("status", array(1, "Tebrikler."));
            \LogActivity::addToLog('Banka düzenlendi.');
        } catch (Exception $e) {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }

        return redirect('admin/settings/bank/detail/' . $id);
    }

    public function bankDelete($id)
    {
        $bank = Bank::find($id);
        if (!empty($bank->image)) {
            $destinationPath = public_path() . '/src/uploads/banks/' . $bank->image;
            if (file_exists($destinationPath)) {
                @unlink($destinationPath);
            }
        }
        try {
            $bank->delete();
            Session()->flash('status', array(1, "Silindi."));
            \LogActivity::addToLog('Banka silindi.');
        } catch (Exception $e) {
            Session()->flash('status', array(1, "Hata Oluştu."));
        }
        return redirect("admin/settings/banks");

    }

    public function bankAdd()
    {
        return view("admin.banks.bankAdd");
    }

    public function bankCreate(Request $request)
    {

        $data = [
            "name"     => $request->get("name"),
            "owner"    => $request->get("owner"),
            "iban"     => $request->get("iban"),
            "currency" => $request->get("currency"),
            "sort"     => $request->get("sort"),
        ];

        if ($request->hasFile('image')) {
            $image           = $request->file('image');
            $destinationPath = public_path() . '/src/uploads/banks/';
            $microtime       = explode(' ', str_replace('0.', null, microtime()));
            $filename        = str_slug($request->get('name')) . $microtime[0] . $microtime[1] . ".jpg";
            $image->move($destinationPath, $filename);
            $data["image"] = $filename;
        }

        $add = Bank::create($data);
        if ($add) {
            $request->session()->flash('status', array(1, "Eklendi."));
            \LogActivity::addToLog('Banka oluşturuldu.');
        } else {
            $request->session()->flash('status', array(0, "Hata Oluştu!"));
        }
        return redirect("admin/settings/banks");

    }

    /*

public function sliderUpdate($id, Request $request)
{
dd($request->all());
}

public function sliderAddArea()
{
$uniq=uniqid();
return '<div class="col-sm-12">
<div class="form-group col-md-1">
<label for="sort" class="col-sm-2 control-label">Sıra</label>
<div class="col-sm-10">
<input style="width:40px;" type="text" class="form-control pull-right" name="slides['.$uniq.'][sort]" id="sort" value="">
</div>
</div>
<div class="form-group col-md-4">
<label class="col-sm-2 control-label">Resim</label>
<div class="col-sm-10">
<div class="fileinput fileinput-new input-group" data-provides="fileinput">
<div class="form-control form-control-line" data-trigger="fileinput">
<i class="glyphicon glyphicon-file fileinput-exists"></i>
<span class="fileinput-filename"></span>
</div>
<span class="input-group-addon btn btn-default btn-file">
<span class="fileinput-new">Seç</span>
<span class="fileinput-exists">Değiştir</span>
<input type="file" name="slides['.$uniq.'][file]">
</span>
<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Sil</a>
</div>
</div>
</div>
<div class="form-group col-md-3">
<label for="name" class="col-sm-2 control-label">Başlık</label>
<div class="col-sm-10">
<input type="text" class="form-control" name="slides['.$uniq.'][name]" id="name" value="">
</div>
</div>
<div class="form-group col-md-3">
<label for="link" class="col-sm-2 control-label">Link</label>
<div class="col-sm-10">
<input type="text" class="form-control" name="slides['.$uniq.'][link]" id="link" value="">
</div>
</div>
<div class="form-group col-md-1">
<div class="col-sm-10">
<a class="btn btn-danger" href=""><i class="fa fa-remove"></i>Kaldır</a>
</div>
</div>
</div>';
}
 */

}
