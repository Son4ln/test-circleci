<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>お問い合わせ確認画面</title>
      <style type="text/css">
         body {
         color: #666;
         font-size: 90%;
         line-height: 120%;
         }
         table {
         width: 98%;
         margin: 0 auto;
         border-collapse: collapse;
         }
         td {
         border: 1px solid #ccc;
         padding: 5px;
         }
         td.l_Cel {
         width: 15%;
         }
         p.error_messe {
         margin: 5px 0;
         color: red;
         }
      </style>
   </head>
   <body>
      <!-- ▲ Headerやその他コンテンツなど　※編集可 ▲-->
      <!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
      <div align="center">以下の内容で間違いがなければ、「送信する」ボタンを押してください。</div>
      <br>
      <br>
      <form action="/contacts" method="POST">
          {{ csrf_field() }}
         <table>
            <tr>
               <td class="l_Cel">内容</td>
               <td>{{ $data['content'] }}<input type="hidden" name="content" value="{{ $data['content'] }}"></td>
            </tr>
            <tr>
               <td class="l_Cel">団体名</td>
               <td>{{ $data['corporate_name'] }}<input type="hidden" name="corporate_name" value="{{ $data['corporate_name'] }}"></td>
            </tr>
            <tr>
               <td class="l_Cel">お名前</td>
               <td>{{$data['name']}}<input type="hidden" name="name" value="{{$data['name']}}"></td>
            </tr>
            <tr>
               <td class="l_Cel">Email</td>
               <td>{{ $data['email'] }}<input type="hidden" name="email" value="{{ $data['email'] }}"></td>
            </tr>
            <tr>
               <td class="l_Cel">TEL</td>
               <td>{{$data['tel']}}<input type="hidden" name="tel" value="{{$data['tel']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">本文</td>
               <td>{{$data['text']}}<input type="hidden" name="text" value="{{$data['text']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">動画の内容</td>
               <td>{{$data['video_content']}}<input type="hidden" name="video_content" value="{{$data['video_content']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">動画の制作本数</td>
               <td>{{$data['video_number']}}<input type="hidden" name="video_number" value="{{$data['video_length']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">映像の尺</td>
               <td>{{$data['video_length']}}<input type="hidden" name="video_length" value="{{$data['video_length']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">納品形式</td>
               <td>{{$data['deliver_date']}}<input type="hidden" name="deliver_date" value="{{$data['deliver_date']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">キャスト人数（出演する場合何名位か、不要の場合は0）</td>
               <td>{{$data['castor']}}<input type="hidden" name="castor" value="{{$data['castor']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">ロケ地の想定</td>
               <td>{{$data['location']}}<input type="hidden" name="location" value="{{$data['location']}}">
               </td>
            </tr>
            <tr>
               <td class="l_Cel">提供いただける素材</td>
               <td>{{$data['docs']}}<input type="hidden" name="docs" value="{{$data['docs']}}">
               </td>
            </tr>
         </table>
         <br>
         <div align="center">
            <input type="hidden" name="mail_set" value="confirm_submit">
            <input type="hidden" name="referer" value="http://app.crluo.com/mail">
            <input type="submit" value="　送信する　">
            <input type="button" value="前画面に戻る" onClick="history.back()">
         </div>
      </form>
      <!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->
      <!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
   </body>
</html>
