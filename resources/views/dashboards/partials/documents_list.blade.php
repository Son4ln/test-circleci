@php
    /**
    * ﾊﾞｲﾄ ｺﾝﾊﾞｰﾄ
    *
    * @param  int     $bytes
    * @return string
    */
    function byteConvert($bytes){
        $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes)/log(1024));
        return sprintf('%.1f '.$s[$e], ($bytes/pow(1024, floor($e))));
    }
    $label = [0=>'', 1=>'社外営業参考資料','弊社資料','実写','実写＆アニメ','アニメーション'];
@endphp
@foreach($documents as $document)
    <div class="card" style='margin:2em;float:left'>
        @if (preg_match('/video/', $document->mime))
            <img class="--img-rounded" style="max-width:100%;max-height:480px;"
            href="#modalPreviewWindow" role="button" data-toggle="modal" data-procname="/admin/file/{{$document->id}}"
            src="/doc/{{$document->filename}}.png" data-mime="{{$document->mime}}">

            <!--video class="card-img" src="/admin/file/{{$document->id}}" poster="/doc/{{$document->filename}}.png"></video-->
        @else
            <img class="card-img" src="/images/document.png" width="auto">
        @endif
        <div class="card-content">
            <p class="card-text">【ジャンル】：<strong>{{ $label[$document->genre]}}</strong></p>
            <p class="card-text">【タイトル】：<span style="line-height:1.1;"><strong>{{$document->title}}</strong></span></p>
            <p class="card-text">【ファイル名】：<span style="line-height:1.1;">{{$document->originalfilename}}</span></p>
            <p class="card-text">【制作費】：<span style="font-size:1.2em;">{{ number_format($document->price)}}</span> 円</p>
            <p class="card-text">【納期】：<span style="font-size:1.2em;">{{$document->days}}</span> 日</p>
            <p class="card-text">【サイズ】：{{byteConvert($document->filesize)}}</p>
            <p class="card-text">【更新日時】：{{$document->created_at->format('Y年m月d日')}}</p>

        </div>
        <div class="card-link">
            <form class="form-horizontal" method="post" action="/documents/{{$document->id}}" >
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <a class="btn btn-success" href="{{ $document->url }}" style="margin-top:.8em;margin-right:.8em;margin-bottom:.8em;padding-right:.5em;padding-left:.5em; color:white;">download</a>
                <button class="btn btn-warning" type="submit" style="margin-top:.8em;margin-right:.8em;padding-right:.5em;padding-left:.5em;">削除</button>
            </form>
        </div>
    </div>
@endforeach
