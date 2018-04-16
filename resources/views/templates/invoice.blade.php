<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{ $project->title . '請求書' }}</title>
</head>
<style>
	* {
	font-family: ipag;
	}
	.wrapper {
	width: 900px;
	margin: auto;
	}
	.text-bold {
	font-weight: bold;
	}

	.text-big {
	font-size: 55px;
	}

	.text-center {
	text-align: center;
	}

	.text-right {
	text-align: right;
	}
	table {
	width: 100%;
	}
	table td {
	border: 1px solid black;
	padding: 7px 20px;
	}
	td.img {
	width: 100%;
	height: 100%;
	}
	.mor-h3-color{
	color:  #229393;
	}
</style>
<body>
	{{-- <div class="wrapper"> --}}
	<h1 class="text-bold text-center text-big mor-h1-color">請求書</h1>
	<h2 class="text-bold">{{ $project->invoice_to }}様</h2>
	<p class="text-right">
		発行日: {{ $project->delivered_at ? $project->delivered_at->format('Y/m/d') : date('Y/m/d') }} <br>
		<br>
		株式会社vivito <br>
		〒151-0053　東京都渋谷区代々木3-36-8　B棟 <br>
		TEL：03-6383-4725 <br>
		FAX：03-6383-4078 <br>
		E-mail：crluo@vi-vito.com <br>
	</p>
	<p>
		プロジェクト名：{{ $project->title }}　制作費 <br>
		下記金額を請求致します。
	</p>
	<h3 class="mor-h3-color">請求金額：{{ number_format($project->offeredProposal()->price3 * 1.08) }}円 （税込）</h3>
	<table cellspacing="0">
		<tr>
		<td align="center" style="width: 100px">日付</td>
		<td align="center" style="width: 250px">品名</td>
		<td align="center">数量</td>
		<td align="center">単位</td>
		<td align="center">単価</td>
		</tr>
		<tr>
		<td>{{ $project->delivered_at ? $project->delivered_at->format('Y/m/d') : date('Y/m/d') }}</td>
		<td>{{ $project->title }}　制作費</td>
		<td>１</td>
		<td>式</td>
		<td align="right">{{ number_format($project->offeredProposal()->price3) }}</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td colspan="2" rowspan="3" style="padding: 0 0 0 1px">
			<img src="{{ public_path() . '/images/stroke.png' }}" alt="">
		</td>
		<td colspan="2" align="center">小　計</td>
		<td align="right">{{ number_format($project->offeredProposal()->price3) }}</td>
		</tr>
		<tr>
		<td colspan="2" align="center">消費税(8%)</td>
		<td align="right">{{ number_format($project->offeredProposal()->price3 * 0.08) }}</td>
		</tr>
		<tr>
		<td colspan="2" align="center">合　計</td>
		<td align="right">{{ number_format($project->offeredProposal()->price3 * 1.08) }}</td>
		</tr>
	</table>
	<br>
	お振込口座 <br><br>
	三井住友銀行　新宿西口支店 普通　3225149 <br><br>
	株式会社vivito（カブシキガイシャビビトー）
	{{-- </div> --}}
</body>
</html>
