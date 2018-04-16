@include('emails.header')
  <div class="content-main">
    <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>

    <p>お問い合わせ誠にありがとうございます。<br>
    {{ $title }} についてのお問い合わせ受け賜わりました。<br></p>

  </div>
@include('emails.footer')
