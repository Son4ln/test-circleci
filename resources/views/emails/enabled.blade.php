@include('emails.header')
  <div class="content-main">
    <div class="mail-compe-image"><img src={{URL::to("/images/welcome.png")}} high="55"></div>
       <h4 style="text-align:center;">{{ $name }} 様 平素より<span style="font-weight:bold; color:#1CA5B6"> CRLUO </span>をご利用頂きまして誠にありがとうございます</h4>

    <h3>{{ $name }} 様</h3>
      <p>
        この度は、クリエイター登録申請いただき誠にありがとうございます。<br>
        無事、審査が終了致しましたので<br>
        クルオへのログインが可能となりました。<br>
        <br>
        ログイン　メールアドレス<br>
        {{ $email }} <br>
        <br>
        ログイン　パスワード<br>
        登録申請時に入力した6文字以上の英数字をご入力ください。<br>
      </p>
    <br>
      <p>
        <strong>ログイン後は、</strong>（こちら→<a href='http://crluo.com/auth/login'>クルオへログイン</a>）<br>
          <p style='color:#0088B8'>
              プロフィールとポートフォリオを充実させて、<br>
              貴方のクリエイティビティーをめいっぱい発揮して下さい!!<br>
              CRLUO(クルオ)は一丸となって、貴方をサポート致します!!<br>
          </p>
        </p>
      <p>
        <h4>‐クリエイターさんへ朗報‐</h4>
        CRLUO(クルオ)をご利用の方に限り、<br>
        (株)vivitoのサービス(ロケセット・スタジオ・モデルetc..)全てを特別価格でご使用頂けます。<br>
        詳しくはvivitoホームページまで。<br>
        URL: <a href='http://roke-suta.jp/'>http://roke-suta.jp/</a><br>
        <br>
      </p>

  </div>
@include('emails.footer')
