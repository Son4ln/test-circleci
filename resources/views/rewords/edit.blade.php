@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">報酬管理</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    {{ Form::model($reword, [
      'url' => route('rewords.update', ['id' => $reword->id]),
      'class' => 'form-horizontal',
      'method' => 'PUT'
    ]) }}
      <div class="form-group">
        <label class="control-label col-sm-2">検収依頼総額</label>
        <div class="col-sm-8">
          {{ Form::text('reword', null, ['class' => 'form-control']) }}
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-8 col-sm-offset-2">
          <button class="btn btn-warning btn-lg">編集</button>
        </div>
      </div>
    {{ Form::close() }}
  </div>
@endsection
