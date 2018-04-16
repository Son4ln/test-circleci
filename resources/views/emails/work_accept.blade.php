@include('emails.header')
<div class="content-main">
  <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>

  <p>{{ $title }} についての検収が行われました。<br>
  プロジェクトは全行程の完了となります。</p>
</div>
@include('emails.footer')
