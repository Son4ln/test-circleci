<?php namespace App\Http\Controllers;

use Crypt;
use Input;
use Mail;
use Request;
use  App\Repositories\PortfolioRepository  as por;
use App\Http\VideoStream;
use Barryvdh\Debugbar\Middleware\Debugbar;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	
	
	/**
	 * Get portfolios and display in /pf
	 * @return Response
	 */
	public function pf(por $por){
		//app('debugbar')->disable();
		$portfolios = $por->getPortfolioByScope(['id','mime','url','thumb_path']);
		return view('index.portfolio', compact('portfolios'));
	}
	
	
	public function portfolio()
	{

	$videos = array();

	$videos = [
		/* 1:kind, 2:target, 2:target, 3:client, 4:creator(option), 5:video url, 6:thumb url, 7:title, 8:detail */

		[ 2, 1, 3, 2, 'クルオ',                              'https://player.vimeo.com/video/175474925', 'https://i.vimeocdn.com/video/582576150_600.jpg',       'クルオ', 'クルオシステム紹介VTR'],

		[ 1, 2, 6, 1, 'クルオ',             'https://www.youtube.com/embed/v4snqcT_DI0', 'http://img.youtube.com/vi/v4snqcT_DI0/mqdefault.jpg', '旭化成ホームプロダクツ', '東京ポータブルパクチーコレクション '],
		[ 3, 6, 10, 1, 'クルオ',             'https://player.vimeo.com/video/208093524', 'https://i.vimeocdn.com/video/623326816_600.jpg', 'DMM VR THEATER', 'アイカツスターズ！プロモーション映像'],
		[ 1, 1, 11, 1, 'クルオ',             'https://player.vimeo.com/video/208094111', 'https://i.vimeocdn.com/video/623327534_600.jpg', 'タイムシークレット', 'プロモーション動画'],
		[ 1, 1, 2, 1, 'クルオ',             'https://player.vimeo.com/video/207903421', 'https://i.vimeocdn.com/video/623101604_600.jpg', 'ボートレース江戸川', '施設紹介映像'],
		[ 1, 1, 2, 1, 'クルオ',             'https://player.vimeo.com/video/207903406', 'https://i.vimeocdn.com/video/623101691_600.jpg', 'ボートレース江戸川', '施設PR動画'],

		[ 1, 2, 10, 1, 'クルオ',             'https://player.vimeo.com/video/202752971', 'https://i.vimeocdn.com/video/616851378_600.jpg', 'よみうりランド', 'よみうりランドPR動画'],
		[ 1, 1, 6, 1, 'クルオ',             'https://player.vimeo.com/video/202746278', 'https://i.vimeocdn.com/video/616843774_600.jpg', 'PANDORA', 'PANDORA紹介動画'],
		[ 1, 1, 10, 1, 'クルオ',             'https://player.vimeo.com/video/202747317', 'https://i.vimeocdn.com/video/616844183_600.jpg', 'Conti', 'Conti紹介動画　6秒ver'],
		[ 1, 1, 10, 1, 'クルオ',             'https://player.vimeo.com/video/202747562', 'https://i.vimeocdn.com/video/616845371_600.jpg', 'Conti', 'Conti紹介動画　30秒ver'],
		[ 1, 1, 2, 1, 'クルオ',             'https://player.vimeo.com/video/202747636', 'https://i.vimeocdn.com/video/616845629_600.jpg', 'Conti', 'Conti館内紹介動画'],
		[ 3, 5, 2, 1, 'クルオ',             'https://player.vimeo.com/video/198439945', 'https://i.vimeocdn.com/video/611425729_600.jpg', '東亜物流株式会社', '東亜物流株式会社 企業紹介動画'],
		[ 1, 2, 9, 2, 'クルオ',   'https://www.invalance.jp/index.html', 'images/903.jpg',             '株式会社インヴァランス', '不動産系企業　HP用ブランディング動画'],
		[ 1, 1, 2, 2, 'クルオ',   'https://loadstarcapital.com/ja/business/loadstarcapital.html', 'images/752.jpg',             'Loadstar Capital K.K.', '不動産系企業　HP用サービスPR動画'],
		[ 1, 13, 6, 2, 'クルオ',   'https://www.youtube.com/embed/RWtTbmUtNSo', 'http://img.youtube.com/vi/RWtTbmUtNSo/mqdefault.jpg',             '映画バイオハザード特番', '映画『バイオハザード：ザ・ファイナル』公開記念特番'],
		[ 2, 8, 5, 1, 'クルオ',             'https://player.vimeo.com/video/195902173', 'https://i.vimeocdn.com/video/609402562_600.jpg', '東亜物流株式会社', '東亜物流株式会社リクルート動画'],
		[ 1, 6, 15, 1, 'クルオ',             'https://www.youtube.com/embed/5WqsmnIdIvA', 'http://img.youtube.com/vi/5WqsmnIdIvA/mqdefault.jpg', 'ジョニー・デップ', '「CLASSIC ROCK AWARDS 2016 」コメント映像'],
		[ 1, 1, 2, 1, 'クルオ',             'https://www.youtube.com/embed/Ni_rY4B92vE', 'http://img.youtube.com/vi/Ni_rY4B92vE/mqdefault.jpg', 'ゲラン パリ', 'ゲラン パリ　ビューティリフト誕生 　小林明実'],
		[ 3, 1, 5, 1, 'MFI',             'https://www.youtube.com/embed/f-5IMMy-ujQ', 'http://img.youtube.com/vi/f-5IMMy-ujQ/mqdefault.jpg', 'サービス紹介動画', '英語塾リラリス'],
		[ 2, 1, 3, 1, 'MFI',             'https://www.youtube.com/embed/8ON7z2T71PE', 'http://img.youtube.com/vi/8ON7z2T71PE/mqdefault.jpg', 'サービス紹介動画', '株式会社MFIサービス紹介'],
		[ 1, 9, 6, 2, 'クルオ＆4thFILM',   'https://www.360ch.tv/videoview/95', 'images/67112.jpg',             '360度VRアイドルホラー', '滝口ひかり デッドエスケープ 株式会社360Channel'],
		[ 1, 9, 6, 2, 'クルオ＆4thFILM',   'https://www.youtube.com/embed/azJgxFNd8Rw', 'http://img.youtube.com/vi/azJgxFNd8Rw/mqdefault.jpg',             '欅坂46「二人セゾン」', '「二人セゾン」TypeA収録「齋藤冬優花」の個人PV予告編 '],
		[ 1, 6, 9, 2, 'クルオ',   'https://www.youtube.com/embed/TI7gg6bUmgg', 'http://img.youtube.com/vi/TI7gg6bUmgg/mqdefault.jpg',             'としまえん 360°動画', '【としまえんNERIMAハロウィン2016】フライングハロウィン360'],
		[ 3, 2, 10, 2, 'クルオ',   'https://www.youtube.com/embed/vMXllZLtgFc', 'http://img.youtube.com/vi/vMXllZLtgFc/mqdefault.jpg',             'KENZO', '"Sun to Sun". KENZO Pre-Fall 2016 movie by Partel Oliva '],
		[ 2, 1, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/190968108', 'https://i.vimeocdn.com/video/601815913_600.jpg',       'ワコール', 'タラレバ娘のブラ選び'],
		[ 1, 9, 2, 2, 'クルオ',   'https://www.youtube.com/embed/s3LgDU_raxk', 'http://img.youtube.com/vi/s3LgDU_raxk/mqdefault.jpg',             'Be marginaL', 'Movie novels Series #1 Revenge and Compliance'],
		[ 1, 1, 6, 2, 'クルオ',                              'https://player.vimeo.com/video/190968103', 'https://i.vimeocdn.com/video/601815388_600.jpg',       'BMW', 'BMW7シリーズ PR Movie'],
		[ 1, 9, 2, 2, 'クルオ',   'https://www.youtube.com/embed/i6Xmi3ws0IY', 'http://img.youtube.com/vi/i6Xmi3ws0IY/mqdefault.jpg',             'VRホラー 3D', 'VRホラー 3D「toilet」'],
		[ 1, 1, 3, 2, 'クルオ',                              'https://player.vimeo.com/video/190956517', 'https://i.vimeocdn.com/video/601799607_600.jpg',       'N Magic Mirror', 'ナクシス株式会社　N Magic Mirror PR Movie Long ver.'],
		[ 1, 14, 2, 2, 'クルオ',   'https://www.youtube.com/embed/lcADCHTMX_4', 'http://img.youtube.com/vi/lcADCHTMX_4/mqdefault.jpg',             'アイドルカレッジ', 'アイドルカレッジ「虹とトキメキのFes」MusicClipFullVer.'],
		[ 1, 1, 2, 2, 'クルオ',                              'https://player.vimeo.com/video/191144479', 'https://i.vimeocdn.com/video/602057969_600.jpg',       'クルオ', 'CRLUO PR Movie'],
		[ 1, 1, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/190956555', 'https://i.vimeocdn.com/video/602030694_600.jpg',       'N Magic Mirror', 'ナクシス株式会社　N Magic Mirror PR Movie Short ver.'],
		[ 1, 1, 10, 2, 'クルオ',   'https://www.youtube.com/embed/_OeIrvFM_64', 'http://img.youtube.com/vi/_OeIrvFM_64/mqdefault.jpg',             'みどりクラウド', '環境モニタリングのみどりクラウド　みどりちゃん編 '],
		[ 1, 1, 10, 2, 'クルオ',   'https://www.youtube.com/embed/FlH49UlXods', 'http://img.youtube.com/vi/FlH49UlXods/mqdefault.jpg',             'みどりクラウド', '温室内環境遠隔モニタリングシステム　みどりクラウド インタビュー動画 '],
		[ 1, 14, 2, 2, 'クルオ',   'https://www.youtube.com/embed/uu871DUoIOI', 'http://img.youtube.com/vi/uu871DUoIOI/mqdefault.jpg',             '無重力クッキー ', '2nd EP Little Ms.Pumpkin MV ~short ver.~ 2nd EP クレイジーソルト '],
		[ 1, 14, 2, 2, 'クルオ',   'https://www.youtube.com/embed/YwzE1yEygxw', 'http://img.youtube.com/vi/YwzE1yEygxw/mqdefault.jpg',             '無重力クッキー ', '2nd EP クレイジーソルト MV ~short ver.~ 2nd EP crazy salt  '],
		[ 1, 1, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/181603837', 'https://i.vimeocdn.com/video/594796792_600.jpg',       'みどりクラウド', 'みどりクラウド　PR動画 お客様の声'],
		[ 1, 1, 6, 2, 'クルオ',                              'https://player.vimeo.com/video/181602746', 'https://i.vimeocdn.com/video/590209703_600.jpg',       'CLEANSE DIET', 'CLEANSE DIET商品紹介'],
		[ 1, 6, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/173573363', 'https://i.vimeocdn.com/video/579961456_600.jpg',       'drop', '2nd Anniversary LIVE　告知VTR'],
		[ 2, 1, 7, 2, 'クルオ',                              'https://player.vimeo.com/video/173300790', 'https://i.vimeocdn.com/video/594796283_600.jpg',       'DMM STARTER', 'DMM STARTER紹介VTR'],
		[ 1, 1, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/168737421', 'https://i.vimeocdn.com/video/573296936_600.jpg',       'breath house ブレスハウス', '群馬県高崎市のおしゃれな新築一戸建て・モデルハウスを紹介'],
		[ 1, 4, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/160849060', 'https://i.vimeocdn.com/video/570947574_600.jpg',       'YYCアプリ', '日本最大級のマッチングサイトYYC紹介VTR'],
		[ 1, 4, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/160849045', 'https://i.vimeocdn.com/video/570947416_600.jpg',       'YYCアプリ', '日本最大級のマッチングサイトYYC紹介VTR'],
		[ 1, 4, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/160849032', 'https://i.vimeocdn.com/video/570946550_600.jpg',       'カフェ・フレ', 'カフェがみつかるカフェ友ひろがるSNS'],
		[ 1, 14, 2, 2, 'クルオ',                              'https://www.youtube.com/embed/CXCXuxWGw0g?rel=0&amp;showinfo=0', 'http://img.youtube.com/vi/CXCXuxWGw0g/mqdefault.jpg',       'Schroeder-Headz', '「Sketch of Leaves」 MV-Short Edit version'],
		[ 1, 5, 8, 2, 'クルオ',                              'https://player.vimeo.com/video/191296289', 'https://i.vimeocdn.com/video/602261236_600.jpg',       '企業リクルート', '企業紹介VTR 会社新年会 動画'],
		[ 3, 5, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/161589457', 'https://i.vimeocdn.com/video/572400075_600.jpg',       '株式会社ZURE', '企業紹介VTR CM'],
		[ 2, 2, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/161589381', 'https://i.vimeocdn.com/video/572400267_600.jpg',       'ATVLab ', 'ATVLab CM'],
		[ 1, 4, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/160849063', 'https://i.vimeocdn.com/video/570947658_600.jpg',       'YYCアプリ', '日本最大級のマッチングサイトYYC紹介VTR'],
		[ 3, 2, 0, 2, 'クルオ',                              'https://player.vimeo.com/video/103312188', 'https://i.vimeocdn.com/video/485513487_295x166.jpg',       '家路', '108FILMS (BUDDHA.inc)'],
		[ 1, 14, 0, 2, 'クルオ',                              'https://player.vimeo.com/video/157268781', 'https://i.vimeocdn.com/video/570946443_600.jpg',       'The810', 'MV The810'],
		[ 1, 1, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/162341385', 'https://i.vimeocdn.com/video/570946038_600.jpg',       'ATVLab', 'PRVTR'],
		[ 1, 2, 0, 2, 'クルオ',                              'https://player.vimeo.com/video/161589485', 'https://i.vimeocdn.com/video/570948198_600.jpg',       'ATVLab', 'ATVLabイメージVTR'],
		[ 1, 9, 10, 2, 'クルオ',                              'https://player.vimeo.com/video/164967681', 'https://i.vimeocdn.com/video/594796574_295x166.jpg',       'LuLine', 'LuLineメイキングVTR'],
		[ 1, 14, 0, 2, 'クルオ',                              'https://player.vimeo.com/video/153356671', 'https://i.vimeocdn.com/video/570946199_600.jpg',       'chocol8 syndrome', 'ストロボchocol8 syndrome'],
		[ 1, 6, 10, 2, 'クルオ',                              'http://player.vimeo.com/video/151852574', 'https://i.vimeocdn.com/video/570946333_600.jpg',       'U-KISS', 'U-KISS長尺SPOT CM'],
		[ 1, 9, 13, 2, 'クルオ',                              'http://player.vimeo.com/video/151489652', 'http://i.vimeocdn.com/video/551246861_600.jpg',       'Zニュース', 'Zニュースダイジェスト'],
		[ 2, 2, 0, 2, 'クルオ',                              'http://player.vimeo.com/video/80590364', 'http://i.vimeocdn.com/video/456551681_600.jpg',       'BUDDHA', '108FILMS (BUDDHA.inc)'],
		[ 3, 1, 10, 2, 'クルオ',                              'http://player.vimeo.com/video/114333390', 'http://i.vimeocdn.com/video/499973666_600.jpg',       '肉バル【熟成肉×ジビエ×新宿三丁目】パンとサーカス', 'サイネージ映像'],
		[ 3, 1, 10, 2, 'クルオ',                              'http://player.vimeo.com/video/124625179', 'http://i.vimeocdn.com/video/514421229_295x166.jpg',       '肉バル【熟成肉×ジビエ×新宿三丁目】パンとサーカス', 'Let’s Party!! パンとサーカスの秘隠小部屋的 ロフト席に突入せよ！'],


		[ 1, 14, 0, 1, '4th FILM',                        'https://player.vimeo.com/video/168039961', 'https://i.vimeocdn.com/video/572476061_600.jpg', '噂のカンチ男', 'ミュージックビデオ'],
		[ 1, 2, 9, 1, '4th FILM',                       'https://player.vimeo.com/video/168039937', 'https://i.vimeocdn.com/video/572466269_600.jpg', '千葉ジェッツPV', 'CHIBA JETS　プロモーションVTR'],
		[ 1, 9, 15, 1, '4th FILM',                   'https://player.vimeo.com/video/168039913', 'https://i.vimeocdn.com/video/572478545_600.jpg', 'インタビュー映像', '中山エミリさんインタビュー映像'],
		[ 1, 10, 0, 1, '4th FILM',                     'https://player.vimeo.com/video/168023494', 'https://i.vimeocdn.com/video/572478180_600.jpg', 'カゴメトマトジュースCM', 'カゴメ株式会社様TVCM'],
		[ 1, 1, 6, 2, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/ZuXVI34QCII', 'https://i.ytimg.com/vi/ZuXVI34QCII/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=AtMVEzino8DjpNWVDnLT6Q5jplA',             'Vasilisa Rola Interview', 'Vasilisa Rola Interview'],

		[ 3, 1, 0, 1, 'はじめプロジェクト',             'https://player.vimeo.com/video/168023108', 'https://i.vimeocdn.com/video/572478455_600.jpg', 'サービス紹介動画', 'リンカーズ株式会社様　製品・サービス紹介動画'],
		[ 1, 1, 4, 1, 'はじめプロジェクト',              'https://player.vimeo.com/video/168023098', 'https://i.vimeocdn.com/video/572478735_600.jpg', 'サービス紹介動画', 'お花宅配サービスsakaseru様　紹介動画'],
		[ 1, 2, 10, 1, 'はじめプロジェクト',                'https://player.vimeo.com/video/168023095', 'https://i.vimeocdn.com/video/572478823_600.jpg', '「いまここ宮崎」', '宮崎移住促進映像「いまここ宮崎」'],
		[ 1, 1, 2, 1, 'はじめプロジェクト',                  'https://player.vimeo.com/video/168023088', 'https://i.vimeocdn.com/video/572479083_600.jpg', 'Global Shapers Camp', ' Global Shapers Camp 2014 by GSC Osaka'],
		//https://i.ytimg.com/vi/3GQ02nXQQiM/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=ltL4XKatRCl_JJpCt2boTJzVkps

		[ 2, 4, 1, 2, 'ダブリュ',                              'https://player.vimeo.com/video/168019655', 'https://i.vimeocdn.com/video/572479695_600.jpg',       'TANREN紹介', 'TANREN(FINAL)製品アプリ紹介VTR'],
		[ 1, 1, 5, 2, 'ダブリュ',                              'https://player.vimeo.com/video/168019691', 'https://i.vimeocdn.com/video/572479568_600.jpg',       '東京芸能学園VTR', '東京芸能学園様の紹介VTR'],
		[ 1, 1, 2, 2, 'ダブリュ',                              'https://player.vimeo.com/video/168020205', 'https://i.vimeocdn.com/video/572479259_600.jpg',       'Ciao紹介', 'Ciao様紹介VTR'],


		[ 1, 4, 10, 2, 'bird & insect',                       'https://player.vimeo.com/video/168018886', 'https://i.vimeocdn.com/video/572480436_600.jpg',  'clip cake紹介', 'clip cake様アプリ紹介'],
		[ 1, 1, 0, 2, 'bird & insect',                       'https://player.vimeo.com/video/168019357', 'https://i.vimeocdn.com/video/572480048_600.jpg',      '八王子セミナーハウス', '八王子セミナーハウス紹介VTR'],
		[ 1, 1, 2, 2, 'bird & insect',                       'https://player.vimeo.com/video/168019154', 'https://i.vimeocdn.com/video/572480249_600.jpg',      'clip フォトブック紹介', 'clip フォトブック様紹介VTR'],
		[ 3, 6, 10, 2, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/FfC9H9DMkBQ', 'https://i.ytimg.com/vi/FfC9H9DMkBQ/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=CwmMrQfr7PtqmyT99NZtL_c1QYk',             'ブルーレイ＆DVD発売記念VTR', 'ブルーレイ＆ＤＶＤ発売告知30秒ＣＭ　劇場版『イナズマイレブンGO ｖｓ ダンボール戦機Ｗ』'],
		[ 1, 1, 2, 1, 'マツウラエイガ',              'https://www.youtube.com/embed/QrkBHu_mVLc', 'https://i.ytimg.com/vi/QrkBHu_mVLc/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=XP5qSnqHS9rx5XB2wR-ni8wDH8Y',             'Lifecinema', 'Lifecinema紹介VTR'],


		[ 1, 14, 0, 1, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/bx2ZVEE0Xj4', 'https://i.ytimg.com/vi/bx2ZVEE0Xj4/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=yvzECj6D6Nv3wCwOw6PpqPN3xpU', 'Buono! ', ' 『Never gonna stop!』 ミュージックビデオ'],
		[ 1, 9, 1, 1, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/V7_C80l3gH8', 'http://i.ytimg.com/vi/V7_C80l3gH8/maxresdefault.jpg', 'Making動画 ', 'SUPER☆GiRLS'],
		[ 3, 6, 10, 2, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/mnIelMLBBu4', 'https://i.ytimg.com/vi/mnIelMLBBu4/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=QroQp6nQGfqnNTX9mBe5yshtdKI', 'ブルーレイ＆DVD発売記念VTR', 'イナズマ グラフィグ4人の「グラフィグはつらいぜ！」編】　劇場版『イナズマイレブンGO vsダンボール戦機Ｗ』ブルーレイ＆DVD発売記念'],
		[ 2, 3, 0, 2, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/DD4dXHAkkPk', 'https://i.ytimg.com/vi/DD4dXHAkkPk/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=_LBnM94NbcgQffwWl6iDiKX0zvM',             'DMMプリント', 'DMMプリント123D応用編'],
		[ 1, 7, 10, 2, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/lIuUPVnStaw', 'https://i.ytimg.com/vi/lIuUPVnStaw/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=Csy_PQetaD8hTE3xwCxJ562d6rc',             'シンデレラガールズコンテスト', 'シンデレラガールズコンテスト淡路ゆり子ヘアメイク編'],
		[ 1, 7, 0, 2, 'モンスターフィルムパートナーズ 布江 剛士',   'https://www.youtube.com/embed/1xE9VbDNBy0', 'https://i.ytimg.com/vi/1xE9VbDNBy0/hqdefault.jpg?custom=true&w=196&h=110&stc=true&jpg444=true&jpgq=90&sp=68&sigh=ZLXjC-phVMjAM19ptP8a2MeyLBQ',             'HAPPY 慶應連合三田会大会', '2014年慶應連合三田会大会アーカイブVTR'],



	];


	$keys = array('kind', 'target', 'target2', 'client', 'creator', 'url_video', 'url_thumb', 'title', 'detail');
	$tmp = array();
	foreach($videos as $video){
		$tmp[] = array_combine ( $keys, $video );
	}
	$videos = $tmp;
	return view('index/portfolio', ['videos' => $videos]);
	}

	public function pr()
	{
		return view('index/services');
	}

	public function forcreator()
	{
		return view('index/forcreator');
	}

	public function about()
	{
		return view('index/about');
	}

	public function atv()
	{
		return view('index/atv');
	}

	public function qa()
	{
		return view('index/qa');
	}

	public function mail()
	{
		return view('index/mail');
	}

	public function privacy()
	{
		return view('index/privacy');
	}

	public function intro()
	{
		return view('index/intro');
	}

	public function marketing()
	{
		return view('index/marketing');
	}

	public function flow()
	{
		return "ご利用の流れ";
	}

	// navbar bottomZ
	public function company()
	{
		return view('widget/company');
	}
	public function rules()
	{
		return view('widget/rules');
	}
	public function policy()
	{
		return view('widget/policy');
	}

	public function request()
	{
		$filename = 'doc/crluo.pdf';

		// crypt
		if (Input::get('filename')) $filename = Input::get('filename');
		$filename = '/download/' . urlencode(Crypt::encrypt(time() . ':' . $filename));

		// mail
		$text = "資料のダウンロード請求がありました\n";
		$input = Input::except('_method', '_token', 'filename');

		foreach ($input as $key => $val){
		$text .= "$key : $val\n";
		}

		Mail::raw($text, function ($message) {
			// MOR 20171208 info@crluo-mail.com => info@vi-vito.com
			$message->to('info@vi-vito.com', 'system')->subject('資料ダウンロード');
		});

		$text = '資料ダウンロードをご請求いただきありがとうございます<br>下記のリンクよりダウンロードを行ってください<br><span style="color:red;">※ 30分後まで有効となります</span>';
		Mail::send('emails.download', [ 'text' => $text, 'url' => $filename], function($message) use ($input) {
		$message->to($input['Eメールアドレス'], $input['ご担当者お名前'])->subject('資料ダウンロードURL');
		});

		return redirect('/');

	}

	public function download($id)
	{
		// decrypt
		$tmp = explode(':', Crypt::decrypt(urldecode($id)));

		if( time() - $tmp['0'] > 1800) return '';

		// header
		return response(file_get_contents($tmp['1']))
			->header('Content-Type', mime_content_type($tmp['1']))
			->header('Content-Disposition', 'attachment; filename="' . basename($tmp['1']) . '"');
	}



	public function guestUrl($id)
	{
		//$id = Input::get('id');
		// crypt
		$url = Request::root() . '/guest/preview/' . urlencode(Crypt::encrypt(time() . ':' . $id));

		return $url;

	}


	public function guestPreview($id)
	{
		// decrypt
		$tmp = explode(':', Crypt::decrypt(urldecode($id)));
		if ( time() - $tmp['0'] > (24 * 60 * 60) ) return '';

		$project = ProjectFile::previewGuest($tmp['1'])->first();

		$data = array('id' => $id, 'project' => $project);

		return view('preview', $data);


	}

	public function guestMovie($id)
	{
		// decrypt
		$tmp = explode(':', Crypt::decrypt(urldecode($id)));
		if ( time() - $tmp['0'] > (24 * 60 * 60) ) return '';

		$project = ProjectFile::previewGuest($tmp['1'])->first();

		$stream = new VideoStream(public_path() . "/projects/" . $project->project_id . "/". $project->title);
		$stream->start();


		// header
		/*
		return response(file_get_contents(public_path() . "/projects/" . $project->project_id . "/". $project->title))
			->header('Content-Type', $project->mime)
			->header('Content-Disposition', 'attachment; filename="' . $id . '"');
		*/
	}


}
