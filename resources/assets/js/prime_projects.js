var signatureEndPoint = '/s3';
var successEndPoint = '/s3/success';
var uploading = false;
var expirationDate = 'expiration_date';

$('#project-form').submit(function(e) {
    if (uploading) {
        alert('ファイルがアップロードされるまでお待ちください');
        e.preventDefault();
    }
});

$.fn.dropFile = function(options) {
    return $(this).each(function() {
        var self = $(this);
        let files = [];
        var uploader = new qq.s3.FineUploader({
            element: document.getElementById(self.prop('id')),
            request: {
                //endpoint: 'https://' + bucketName + '.' + 's3' + '-' + region + '.amazonaws.com',
                endpoint:'https://'+bucketName+'.s3-accelerate.amazonaws.com',
                accessKey: accessKey,
                // secretKey: secretKey,
            },
            // autoUpload: false,
            signature: {
                endpoint: signatureEndPoint,
                customHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            chunking:{
                partSize:5242880*4
            },
            validation: {
                sizeLimit: 5368709120
            },
            uploadSuccess: {
                endpoint: successEndPoint
            },
            objectProperties: {
                key: function(uuid) {
                    return 'prime-project/' + uploader.getName(uuid);
                },
                acl: 'public-read'
            },
            deleteFile: {
                enabled: true,
                endpoint: '/s3/delete',
                customHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            cors: {
                expected: true,
            },
            callbacks: {
                onProgress: function(id, name, uploadedBytes, totalBytes) {
                    loading = true;
                },

                onAllComplete: function(succeeded, failed) {
                    loading = false;
                    $(options.input).val(joinString(files));
                },

                onComplete: function(id, name, responseJson) {
                    if (responseJson.success) {
                        var link = responseJson.tempLink.split('?')[0];
                        files.push({id: id, name: name, path: link});
                    }
                },

                onDelete: function(id) {
                    $.each(files, function(index) {
                        if (files[index].id == id) {
                            files.splice(index, 1);
                            return;
                        }
                    });
                    $(options.input).val(joinString(files));
                }
            }
        });
    });
};


function joinString(list) {
    let results = [];
    for (let i = 0; i < list.length; i++) {
        results.push({name: list[i].name, path: list[i].path});
    }

    return JSON.stringify(results);
}

$('[data-change="business"]').change(function() {
    sendOwnerContentsToPreviewPart()
});

$('[data-change="keyword"]').change(function() {
    sendTellAboutMovie3ContentsToPreviewPart()
});

// 発注主の業種 を preview部分に反映する
function sendOwnerContentsToPreviewPart() {
    preview = "";
    if ($("#industry_of_owner").val() != null) {
        preview += " 業種：" + $("#industry_of_owner").children("option").filter(":selected").text();
    }
    if ($("#corporate_name_of_owner").val() != "") {
        preview += ", 法人名：" + $("#corporate_name_of_owner").val();
    }
    if ($("#url_of_owner").val() != "") {
        preview += ", ＵＲＬ：" + $("#url_of_owner").val();
    }
    $(".preview_owner span:first").text(escapeHtml(preview));
    validate();
}

// あなたの動画について教えてください 動画の構成要素で外せないキーワード を preview部分に反映する
function sendTellAboutMovie3ContentsToPreviewPart() {
    preview = $("#tell_about_movie_31").val();
    if ($("#tell_about_movie_32").val() != "") {
        if (preview != "") {
            preview += ", ";
        }
        preview += $("#tell_about_movie_32").val();
    }
    if ($("#tell_about_movie_33").val() != "") {
        if (preview != "") {
            preview += ", ";
        }
        preview += $("#tell_about_movie_33").val();
    }
    $(".preview_tell_about_movie_3 span:first").text(escapeHtml(preview));
    validate();
}

// レンジスライダー
function slider(obj) {

    // テキストボックスからの入力の場合
    if (obj) {

        if (!$.isNumeric(obj.value)) {
            obj.focus();
            sendMovieScaleToPreviewPart("", "");
            return false;
        }

        var intLowerLimit = parseInt($("#lower_limit").val());
        var intUpperLimit = parseInt($("#upper_limit").val());

        // マイナス入力の場合
        if ((intLowerLimit < 0) || (intUpperLimit < 0)) {
            obj.focus();
            sendMovieScaleToPreviewPart("", "");
            return false;
        }

        // 範囲を超えた場合
        if ((intLowerLimit < 1) || (60 < intUpperLimit)) {
            obj.focus();
            sendMovieScaleToPreviewPart("", "");
            return false;
        }

        // 上限値 < 下限値の場合
        if (intUpperLimit < intLowerLimit) {
            obj.focus();
            sendMovieScaleToPreviewPart("", "");
            return false;
        }

    }

    $(function () {
        $("#slider-range").slider({
            range: true,
            min: 1,
            max: 60,
            values: [$("#lower_limit").val(), $("#upper_limit").val()],
            slide: function (event, ui) {
                var lowerLimitAfterMovement = ui.values[0];
                var upperLimitAfterMovement = ui.values[1];
                $("#lower_limit").val(lowerLimitAfterMovement);
                $("#upper_limit").val(upperLimitAfterMovement);
                sendMovieScaleToPreviewPart($("#lower_limit").val(), $("#upper_limit").val());
            }
        });
    });
    sendMovieScaleToPreviewPart($("#lower_limit").val(), $("#upper_limit").val());
}


// 予算をpreview部分に反映する
function sendMovieScaleToPreviewPart(lowerLimit, upperLimit) {
    var scale = "";
    if (lowerLimit != "" && upperLimit != "") {
        scale = lowerLimit + "～" + upperLimit + "秒";
    }
    $(".preview_movie_scale span:first").text(escapeHtml(scale));
    validate();
}


// レンジスライダーを初期化
function initializeSlider() {
    if ($("#lower_limit").val() == "") {
        $("#lower_limit").val(15);
    }
    if ($("#upper_limit").val() == "") {
        $("#upper_limit").val(21);
    }
    slider();
}


// 背景を設定し、preview部分に内容をコンマ区切りで反映する
function setBackgroundAndSendContentsToPreviewPartWithCommaDelimited(bindClassName, styleOfCheckedOn) {
    preview = "";
    $(".bind_" + bindClassName + " input[type='checkbox']:checked").each(function () {
        $(this).parent().addClass(styleOfCheckedOn);
        txt = $(this).next().text();
        if (txt != "") {
            delimiter = (preview == "") ? "" : ",";
            preview += delimiter + txt;
        }
    });

    $(".bind_" + bindClassName + " input[type='radio']:checked").each(function () {
        txt = $(this).next().text();
        if (txt != "") {
            delimiter = (preview == "") ? "" : ",";
            preview += delimiter + txt;
        }
    });

    // 動画のアスペクト比 の場合は、その他を追加する
    if (bindClassName == aspectRatio) {
        if ($("#aspect_ratio_another").val() != "") {
            if (preview != "") {
                preview += ",";
            }
            preview += $("#aspect_ratio_another").val();
        }
    }
    $(".preview_" + bindClassName + " span:first").text(escapeHtml(preview));
    validate();
}

/*
*  メイン処理 開始
*/

// 動画の目的
var purpose = "purpose";
// あなたの動画について教えてください ○○○させるのは何ですか？
var tellAboutMovie1 = "tell_about_movie_1";
// あなたの動画について教えてください 今回作る動画で視聴者に伝えたいポイントを入力してください
var tellAboutMovie2 = "tell_about_movie_2";
// あなたの動画について教えてください 詳細
var tellAboutMovieDetail = "tell_about_movie_detail";
// イメージに近い動画
var closeToImage = "close_to_image";
// 動画のアスペクト比
var aspectRatio = "aspect_ratio";
// プロジェクト名
var projectName = "project_name";
// 納品日
var deliveryDate = "delivery_date";
// 参考になる会社案内、商品資料
var referenceInformation = "reference_information";
// クリエイティブの基準になる動画
var criterionOfCreative = "criterion_of_creative";

// ラベル選択時のスタイル
var labelBackOn = "label-back-on";
// 動画選択時のスタイル
var movieBackOn = "movietype1-back-on";


// 動画の目的
setOnChangeForRadioButton(purpose, labelBackOn);

// あなたの動画について教えてください
setOnChangeForInputText(tellAboutMovie1, "");
setOnChangeForInputText(tellAboutMovie2, "");
// あなたの動画について教えてください 詳細
setOnChangeForInputText(tellAboutMovieDetail, "");

// イメージに近い動画
setOnChangeForRadioButton(closeToImage, labelBackOn);

// 動画のアスペクト比
setOnChangeForRadioButton(aspectRatio, labelBackOn);
setOnChangeForCheckbox(expirationDate, labelBackOn);
// 動画のアスペクト比 その他 のonChangeアクションをバインドする
$("#aspect_ratio_another").change(function () {
    $(".bind_aspect_ratio input[type='checkbox']").trigger("change");
});

// プロジェクト名
setOnChangeForInputText(projectName, "");

// 納品日
$.datepicker.setDefaults($.datepicker.regional["ja"]);
$("#" + deliveryDate).datepicker();
$("#expiration_date").datepicker({
    dateFormat: 'yy/mm/dd'
});
setOnChangeForInputText(deliveryDate, "");
setOnChangeForCheckbox(deliveryDate, labelBackOn);

// 参考になる会社案内、商品資料
setOnChangeForInputText(referenceInformation, "");

// クリエイティブの基準になる動画
setOnChangeForInputText(criterionOfCreative, "");
setOnChangeForInputText(expirationDate, "");

$(document).ready(function () {

   // #で始まるアンカーをクリックしたらスムーズスクロールする
   clickOnNextArrow();

   // input属性にchangeを発生させ、動画背景設定等を走らせる
   $("input[type='radio']").trigger('change');
   $("input[type='checkbox']").trigger('change');

   // プレビューへ反映させる
   sendOwnerContentsToPreviewPart();
   sendTellAboutMovie3ContentsToPreviewPart();
   // テキスト項目にchangeを発生させ、プレビューへ反映させる
   $("textarea").trigger('change');
   $("#" + projectName).trigger('change');
   $("#" + referenceInformation).trigger('change');
   $("#" + criterionOfCreative).trigger('change');

   // 納品日は、テキストとチェックボックスのどちらか
   if ($("#" + deliveryDate).val() != "") {
     $("#" + deliveryDate).trigger("change");
   } else {
     $(".bind_" + deliveryDate + " input[type='checkbox']").trigger("change");
   }

   if ($('#expiration_date').val() != "") {
       $('#expiration_date').trigger("change");
   } else {
       $(".bind_" + expirationDate + " input[type='checkbox']").trigger("change");
   }

   validate();

   initializeSlider();

   $('#project-form').on('click', 'button[type="submit"]', function (e) {
     e.preventDefault();

     // Break if button is disabled
     if ($(this).prop('disabled')) {
       return false;
     }

     $(this).parent().find('input[name="status"]').val($(this).attr('data-state'));
     $('#project-form').submit();
   });

 });

 // バリデーションを行う
function validate() {
 var result = true;

 $("#preview_table td").each(function () {

     // バリデーション対象外

     if ($(this).hasClass('preview_expiration_date')) {
         if ($('input[name="is_expiration_undecided"]').prop('checked')) {
             $(this).children("a").css("color", "#333")
             $(this).children('span:first').text('未定')
             return;
         }
         if (isValidExpirationDate($('#expiration_date').val())) {
             $(this).children('span:first').text($('#expiration_date').val());
         } else {
             $(this).children('span:first').text('');
         }
     }

     if ($(this).hasClass("preview_tell_about_movie_3")) {
         // 動画の構成要素で外せないキーワード
         return;
     }
     if ($(this).hasClass("preview_reference_information")) {
         // 参考になる、会社案内、商品資料
         return;
     }
     if ($(this).hasClass("preview_criterion_of_creative")) {
         // クリエイティブの基準
         return;
     }

     if ($(this).hasClass("preview_close_to_image") && $(this).has('img')) {
         return;
     }

     var content = $(this).children("span:first").text();
     if (content == "") {
         $(this).children("a").css("color", "red");
         result = false;
     } else {
         $(this).children("a").css("color", "#333");
     }

     if ($(this).hasClass("preview_owner")) {
       if (isURL($('#url_of_owner').val()) && $('#corporate_name_of_owner').val() != '' && $('#industry_of_owner').val() != null) {
         $(this).children("a").css("color", "#333");
       } else {
         $(this).children("a").css("color", "red");
         result = false;
       }
       // クリエイティブの基準
       return;
     }
 });

 // "あなたの動画について教えてください" 下段のフリーテキストエリアは、3000字未満
 if (3000 < $(".preview_tell_about_movie_detail span:first").text().length || $('.preview_tell_about_movie_detail span').text().trim() == '') {
     $("#preview_tell_about_movie_detail_pencil").css("color", "red");
     result = false;
 } else {
     $("#preview_tell_about_movie_detail_pencil").css("color", "#333");
 }

 // エラー無ければsubmitボタンを有効にする
 if (result) {
     $("button[type='submit']").prop("disabled", false);
 }
}



 /*
 * ラジオボタンのonChangeアクションを設定する
 *
 * bindClassName    バインド対象のラジオボタンを識別するクラス名
 * styleOfCheckedOn ラジオボタンに適用するスタイル（クラスセレクタ）
 */
 function setOnChangeForRadioButton(bindClassName, styleOfCheckedOn) {
     $(".bind_" + bindClassName + " input[type='radio']").change(function(e) {
         setBackgroundAndSendContentsToPreviewPartWithCommaDelimited(bindClassName, styleOfCheckedOn);
         if ($(this).is(":checked")){
             // チェックONの場合、ONのクラスを追加する

             $(".bind_" + bindClassName + " input[type='radio']").parent().removeClass(styleOfCheckedOn);
             $(this).parent().addClass(styleOfCheckedOn);

             if (bindClassName == "close_to_image") {
                 // イメージに近い動画は？ の場合
                 $(".bind_" + bindClassName + " input[type='radio']").parent().parent().removeClass(styleOfCheckedOn);
                 $(this).parent().parent().addClass(styleOfCheckedOn);
                 $img = $(this).siblings('img').clone(); $img.attr('width', 300); $img.attr('height', 200);
                 $('.preview_' + bindClassName).html($img);
             }

             if (bindClassName == "purpose") {
                 // 動画の目的は何ですか？ の場合
                 var purposetext = $(this).parent().text() + "を獲得するのは何ですか？";
                 $(".purposetext").text(purposetext);
             }

         }

     });
 }

 /*
 * チェックボックスのonChangeアクションを設定する
 *
 * bindClassName    バインド対象のチェックボックスを識別するクラス名
 * styleOfCheckedOn チェックボックスに適用するスタイル（クラスセレクタ）
 */
 function setOnChangeForCheckbox(bindClassName, styleOfCheckedOn) {
     $(".bind_" + bindClassName + " input[type='checkbox']").change(function(e) {
         setBackgroundAndSendContentsToPreviewPartWithCommaDelimited(bindClassName, styleOfCheckedOn);
         validate();
         if ($(this).prop('checked') == true) {

             // チェックONの場合、ONのクラスを追加する
             $(this).parent().addClass(styleOfCheckedOn);

             if (bindClassName == deliveryDate) {
                 // 納品日の場合、inputテキストを無効にする
                 $("#delivery_date").prop("disabled", true);
             }

             if (bindClassName == expirationDate) {
                 // 納品日の場合、inputテキストを有効にして、プレビューへの反映する
                 $("#expiration_date").prop("disabled", true);
             }

         } else {

             // チェックOFFの場合、ONのクラスを削除する
             $(this).parent().removeClass(styleOfCheckedOn);

             if (bindClassName == deliveryDate) {
                 // 納品日の場合、inputテキストを有効にして、プレビューへの反映する
                 $("#delivery_date").prop("disabled", false);
                 $("#" + bindClassName).trigger('change');
             }
             if (bindClassName == expirationDate) {
                 // 納品日の場合、inputテキストを有効にして、プレビューへの反映する
                 $("#expiration_date").prop("disabled", false);
                 $("#expiration_date").trigger('change');
             }

         }
     });
 }

 /*
 * テキスト入力（input[type=text], textare）のonChangeアクションを設定する
 *
 * bindId       バインド対象のタグを識別するid名
 * defaultValue 値が空の場合の初期値
 */
 function setOnChangeForInputText(bindId, defaultValue) {
     $("#" + bindId).change(function(e) {
         var textValue = defaultValue;
         if ($(this).val() != "") {
             textValue = $(this).val();
         }
         // preview部分に反映する
         $(".preview_" + bindId + " span:first").text(escapeHtml(textValue));
         if (bindId == expirationDate) {
             if (isValidExpirationDate($('#' + bindId).val())) {
                 $('#expired_at_error').text('');
             } else {
                 $('#expired_at_error').text($('#expired_at_error').data('message'));
             };
         }
         validate();
     });
 }

 function isURL(str) {
   var pattern = new RegExp(/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/); // fragment locater
   return pattern.test(str);
 }

 // #で始まるアンカーをクリックしたらスムーズスクロールする
 function clickOnNextArrow() {
     $('a[href^="#"].scrollarrow-blue50, a[href^="#"].scrollarrow-blue80').click(function() {
         // スクロールの速度（ミリ秒）
         var speed = 700;
         // アンカーの値取得
         var href= $(this).attr("href");
         // 移動先を取得
         var target = $(href == "#" || href == "" ? 'html' : href);
         // 移動先を数値で取得 （25 = 上に一文字分余白を設ける）
         var position = target.offset().top - 25;
         // スムーズスクロール
         $('body,html').animate({scrollTop:position}, speed, 'swing');
         return false;
     });
 }

 // XSS対策用のhtmlエスケープ
 function escapeHtml (string) {
     if(typeof string !== 'string') {
         return string;
     }
     return string.replace(/[&'`"<>]/g, function(match) {
         return {
             '&': '&amp;',
             "'": '&#x27;',
             '`': '&#x60;',
             '"': '&quot;',
             '<': '&lt;',
             '>': '&gt;',
         }[match]
     });
 }

 function addDays(theDate, days) {
     return new Date(theDate.getTime() + days*24*60*60*1000);
 }

 function isValidExpirationDate(date)
 {
     var now = new Date();
     var jst = 540 + now.getTimezoneOffset();

     var today = new Date(now.valueOf() + jst * 60000);

     today = addDays(today, 30);

     var compareDate = new Date(date);

     return (compareDate > now) && (compareDate < today);
 }
