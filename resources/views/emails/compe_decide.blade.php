@include('emails.header')
<div class="content-main">
   <div class="mail-compe-image"><img src={{URL::to("/images/newcompe.png")}} width="650"></div>
    <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>

    <p>あなたは {{ $title }} プロジェクトにて担当クリエイターとして選定されました。<br>
    まずは担当者の方にメッセージを送って制作をスタートさせましょう。<br></p>
</div>
@include('emails.footer')
