@include('emails.header')
  <div class="content-main">
     <div class="mail-compe-image"><img src={{URL::to("/images/newcompe.png")}} width="650"></div>
     <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>

    <p>クルオ運営です。<br>
    {{ $title }} についてのコンペを応募開始いたしました。<br>
    CRLUOでの動画制作体験をお楽しみ下さい。<br><br>
  </div>
@include('emails.footer')
