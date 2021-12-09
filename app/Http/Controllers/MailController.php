<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;

class MailController extends Controller
{
    public function groupList()
    {
        return view("admin.mailGroupList");
    }
    
    public function groupListDatatable()
    {
        $group = \App\MailGroup::All();
        return Datatables::of($group)->make(true);
    }

    public function mailGroupShortEdit(Request $request)
    {
        $pro = \App\MailGroup::find($request->get("id"));
        $message = '<div id="edit_mailGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div style="max-width:600px" class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_brand" method="post" action="'.url('admin/mail/mailGroupShortUpdate/').'/'.$pro->id.'" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Hızlı Düzenle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Adı</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="'.$pro->name.'" name="name" id="name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Güncelle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                    </form>
                                </div>
                            </div>
        </div>';
        $data = ["status"=>true,"message"=>$message];
        return json_encode($data);
    }

    public function mailGroupShortUpdate(Request $request,$id)
    {
        $group=\App\MailGroup::find($id);
        $data=["name"=>$request->get("name")];
        try{
            $group->update($data);
            $request->session()->flash('status',array(1,"Tebrikler!"));
        }catch(Exception $e){
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect('admin/mail/groupList');
    }

    public function mailGroupCreate(Request $request)
    {
        $data=["name"=>$request->get("name")];
        try{
            \App\MailGroup::create($data);
            $request->session()->flash('status',array(1,"Tebrikler!"));
        }catch(Exception $e){
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect('admin/mail/groupList');
    }

    public function mailGroupDelete($id)
    {
        $group=\App\MailGroup::find($id);
        try{
            $group->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(0,"Hata Oluştu!."));
        }
        return redirect('admin/mail/groupList');
    }
    
    public function mailList()
    {
        return view("admin.mailList");
    }
    
    public function mailListDatatable()
    {
        $mails = \App\MailList::All();
        return Datatables::of($mails)->make(true);
    }
    
    public function mailGroupAjaxList()
    {
        return \App\MailGroup::paginate(15);
    }

    public function mailListShortEdit(Request $request)
    {
        $pro = \App\MailList::find($request->get("id"));
        $message = '<div id="edit_mailGroup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div style="max-width:600px" class="modal-dialog">
                                <div class="modal-content">
                                    <form id="add_brand" method="post" action="'.url('admin/mail/mailListShortUpdate/').'/'.$pro->id.'" class="form-horizontal form-bordered">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Hızlı Düzenle</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Adı</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="'.$pro->name.'" name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-3 control-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="'.$pro->email.'" name="email" id="email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="group_id" class="col-sm-3">Mail Listesi Grubu</label>
                                                <div class="col-sm-9">
                                                    <select name="group_id" id="group_id" class="group-ajax js-states form-control add_form" tabindex="-1" style="display: none; width: 100%">
                                                        <option selected="selected" value="'.@$pro->group->id.'">'.@$pro->group->name.'</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Güncelle</button>
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Kapat</button>
                                        </div>
                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                    </form>
                                </div>
                            </div>
        </div>
        <script>
                // Mail Grup Ajax
                $(".group-ajax").select2({
                    language: "tr",
                    ajax: {
                        url: "'.url("admin/mail/mailGroup/ajaxList").'",
                        dataType: \'json\',
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
                    placeholder: \'Grup Seçiniz\'
                });
            </script>';
        $data = ["status"=>true,"message"=>$message];
        return json_encode($data);
    }

    public function mailListShortUpdate(Request $request,$id)
    {
        $email=\App\MailList::find($id);
        $data=[
            "groupId"=>$request->get("group_id"),
            "name"=>$request->get("name"),
            "email"=>$request->get("email")
        ];
        try{
            $email->update($data);
            $request->session()->flash('status',array(1,"Tebrikler!"));
        }catch(Exception $e){
            $request->session()->flash('status',array(0,"Hata Oluştu!"));
        }
        return redirect('admin/mail/maillist');
    }

    public function mailListDelete(Request $request, $id)
    {
        $mail=\App\MailList::find($id);
        try{
            $mail->delete();
            Session()->flash('status', array(1,"Silindi."));
        }catch(Exception $e){
            Session()->flash('status', array(0,"Hata Oluştu!."));
        }
        return redirect('admin/mail/maillist');
    }

}
