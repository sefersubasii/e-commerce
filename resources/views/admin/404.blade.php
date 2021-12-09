<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>404 not found</title>
	<link href="{{asset('src/admin/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
	<style>
	  .center {text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;}
	  </style>
</head>
<body>
	<div class="container">
	  <div class="row">
	    <div class="span12">
	      	<div class="hero-unit center">
	          <h1> Sayfa bulunamadı <small><font face="Tahoma" color="red"> 404 not found</font></small></h1>
	          <br />
	          <p>Aradığınız sayfa bulunamamıştır.</p>
	          <p><b>Tarayıcınız üzerinden GERİ gidebilir ya da ANASAYFA ‘ya dönebilirsiniz.</b></p>
	          <a href="{{url('admin')}}" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> ANASAYFA</a>
	        </div>
	    </div>
	  </div>
	</div>

</body>
</html>
