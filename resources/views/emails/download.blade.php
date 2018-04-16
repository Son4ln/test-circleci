@include('emails.header')
  <div class="content-main">
    <h4 style="text-align:center;"><span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>
    <p>
      {!! $text !!}<br>
      <a href='{{ url($url) }}'> ファイルダウンロードはこちら </a>
      <br>
    </p>
  </div>
@include('emails.footer')
