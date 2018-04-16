@include('emails.header')
  <div class="content-main">
    <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>
    <p>{{ $title }} について納品物がアップロードされました。<br>
    クルオの確認をお待ちください。<br></p>
  </div>
@include('emails.footer')
