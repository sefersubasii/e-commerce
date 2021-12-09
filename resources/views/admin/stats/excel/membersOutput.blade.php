<html>

    <!-- Horizontal alignment -->
    <tr>
        <td style="background-color: #ccc;" colspan="9" align="center"><strong>Üye Raporu {{\Carbon\Carbon::now()->format('d/m/Y H:i:s')}}</strong></td>
    </tr>

    <tr></tr>
    
    <tr>
        <td style="border:1px solid #000;background-color: #999;"><strong>ID</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Ad</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Soyad</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Cinsiyet</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Email</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Telefon</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Cep Telefonu</strong></td>
        <?php /* <td style="border:1px solid #000;background-color: #999;"><strong>Ülke</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Şehir</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>İlçe</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Adres</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Vergi No</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Vergi Dairesi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Doğum Tarihi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Kayıt Tarihi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Son Giriş Tarihi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>En Son IP Adresi</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Puan</strong></td>
        <td style="border:1px solid #000;background-color: #999;"><strong>Mail Listesi</strong></td>
        */ ?>
    </tr>

    @php
        $data->chunk(1000, function($rows){
	@endphp
    @foreach($rows as $key => $member)
        <tr>
            <td>{{@$member->id}}</td>
            <td>{{@$member->name}}</td>
            <td>{{@$member->surname}}</td>
            <td>{{@$member->gender == 1 ? 'Bay' : 'Bayan' }}</td>
            <td>{{@$member->email}}</td>
            <td>{{@$member->phone}}</td>
            <td>{{@$member->phoneGsm}}</td>
            <?php /* <td>{{@$member->Address->country->name}}</td>
            <td>{{@$member->Address->city->name}}</td>
            <td>{{@$member->Address->district->name}}</td>
            <td>{{@$member->Address->address}}</td>
            <td>{{@$member->tax_number}}</td>
            <td>{{@$member->tax_office}}</td>
            <td>{{@$member->bday}}</td>
            <td>{{@$member->created_at}}</td>
            <td>{{@$member->last_login_at}}</td>
            <td>{{@$member->last_login_ip}}</td>
            <td>{{@$member->points}}</td>
            <td>{{@$member->allowed_to_mail == 1 ? 'Açık' : 'Kapalı' }}</td>
            */ ?>
        </tr>
    @endforeach
    @php
        });
    @endphp


    <?php /*
    <!--  Vertical alignment -->
    <td valign="middle">Bold cell</td>

    <!-- Rowspan -->
    <td rowspan="3">Bold cell</td>

    <!-- Colspan -->
    <td colspan="6">Italic cell</td>

    <!-- Width -->
    <td width="100">Cell with width of 100</td>

    <!-- Height -->
    <td height="100">Cell with height of 100</td>
    */ ?>
</html>
