@extends('frontEnd.layout.master')

@section('content')


<div class="container">

	<div class="container_ic">
		
		<div class="sayfa_bulunamadi">
			
			<strong>404!</strong>
			
			<span>Sayfa Görüntülenemiyor!</span>
			
			<a href="{{url('./')}}">Anasayfa İçin Lütfen Tıklayınız</a>
			
		</div>
		
		

	</div>
	

		
		<div class="container_ic">
		
			

			@include('frontEnd.include.footerTop')
			

			<div class="clear"></div>
		</div>
		
		
		
		
		
</div>


@endsection