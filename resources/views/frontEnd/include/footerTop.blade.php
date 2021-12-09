<div class="ana_yorum_alan">
    <strong class="yorum_baslik">MÜŞTERİ YORUMLARI</strong>
    <ul class="ana_yorum">
        @forelse ($comments as $comment)
            <div class="ana_yorum_icerik">
                <div class="ay_left">
                    <strong>{{ $comment->name }}</strong>
                    <span>Müşteri</span>
                </div>
                <div class="ay_right">
                    {{ $comment->message }}
                </div>
            </div>
        @empty
        @endforelse
    </ul>
</div>
<div class="bulten">

    <div class="bulten_ic">

        <strong>AVANTAJI YAKALA</strong>

        @if(isset($errors) && $errors->has('emailbulten'))
            <span class="alert">
                {{ @$errors->first('emailbulten') }}
            </span>

        @else
            <span>Ücretsiz olarak e-bülten aboneliğinizi başlatarak yeni<br>
            kampanya ve ürünlerimizden anında haberdar olun!</span>
        @endif

        @if(session()->has('messageBulten'))
            <script>
                alert("{{ session()->get('messageBulten') }}");
            </script>
        @endif

        <div class="bulten_alan">
            <form id="ebultenF" method="post" action="{{url('bulten/kayit')}}">
            <input name="emailbulten" type="text" placeholder="E-Mail adresinizi yazınız" class="ba_input">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <a type="submit" onclick="$('#ebultenF').submit()" class="ba_buton"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
        </form>
        </div>

    </div>

</div>
