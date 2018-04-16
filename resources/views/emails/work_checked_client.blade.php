@include('emails.header')
  <div class="content-main">
    <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>
    <p>{{ $title }} の納品物についてクルオの確認が行われました。<br>
    クルオにログインの上、ダウンロードを行ってください。<br>
    納品物を確認後、問題がなければクルオにて検収を行ってください。<br></p>
  </div>
@include('emails.footer')
