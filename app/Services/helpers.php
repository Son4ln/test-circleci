<?php
use Aws\S3\S3Client;
function s3DownloadUrl($file)
{
    $AWSAccessKeyId = env('AWS_KEY');
    $AWSSecretAccessKey = env('AWS_SECRET');
    $BucketName = env('AWS_BUCKET');
    $AWSRegion = env('AWS_REGION');
    $expires = 604800;
    $canonical_uri = preg_replace('/^https.*amazonaws.com/', '', $file->path);
    $encoded_uri = str_replace('%2F', '/', rawurlencode($canonical_uri));
    // Specify the hostname for the S3 endpoint
    if($AWSRegion == 'us-east-1') {
        $hostname = trim($BucketName .".s3.amazonaws.com");
        $header_string = "host:" . $hostname . "\n";
        $signed_headers_string = "host";
    } else {
        $hostname = trim($BucketName . ".s3-" . $AWSRegion . ".amazonaws.com");
        $header_string = "host:" . $hostname . "\n";
        $signed_headers_string = "host";
    }
    $date_text = gmdate('Ymd', time());
    $time_text = $date_text . 'T000000Z';
    $algorithm = 'AWS4-HMAC-SHA256';
    $scope = $date_text . "/" . $AWSRegion . "/s3/aws4_request";
    $x_amz_params = array(
        'X-Amz-Algorithm' => $algorithm,
        'X-Amz-Credential' => $AWSAccessKeyId . '/' . $scope,
        'X-Amz-Date' => $time_text,
        'X-Amz-SignedHeaders' => $signed_headers_string,
        // 'response-content-description' => 'File Transfer',
        'response-content-disposition' => "attachment; filename=" . $file->title,
        'response-content-type' => $file->mime
    );
    if ($expires > 0) {
        // 'Expires' is the number of seconds until the request becomes invalid
        $x_amz_params['X-Amz-Expires'] = $expires;
    }
    ksort($x_amz_params);
    $query_string = "";
    foreach ($x_amz_params as $key => $value) {
        $query_string .= rawurlencode($key) . '=' . rawurlencode($value) . "&";
    }
    $query_string = substr($query_string, 0, -1);
    $canonical_request = "GET\n" . $encoded_uri . "\n" . $query_string . "\n" . $header_string . "\n" . $signed_headers_string . "\nUNSIGNED-PAYLOAD";
    $string_to_sign = $algorithm . "\n" . $time_text . "\n" . $scope . "\n" . hash('sha256', $canonical_request, false);
    $signing_key = hash_hmac('sha256', 'aws4_request', hash_hmac('sha256', 's3', hash_hmac('sha256', $AWSRegion, hash_hmac('sha256', $date_text, 'AWS4' . $AWSSecretAccessKey, true), true), true), true);
    $signature = hash_hmac('sha256', $string_to_sign, $signing_key);
    return 'https://' . $hostname . $encoded_uri . '?' . $query_string . '&X-Amz-Signature=' . $signature;
}
function s3UrlDownloadGenerator($urlFile){
    
    $AWSAccessKeyId = env('AWS_KEY');
    $AWSSecretAccessKey = env('AWS_SECRET');
    $BucketName = env('AWS_BUCKET');
    $AWSRegion = env('AWS_REGION');
    $bucketName = env('AWS_BUCKET');
   
    $strReplace = 'https://'.$bucketName.'.s3.'.$AWSRegion.'.amazonaws.com/';
    $strReplace1 = 'https://'.$bucketName.'.s3-ap-northeast-1.amazonaws.com/';
    $key = str_replace($strReplace, '' ,urldecode( $urlFile ));
    $key = str_replace($strReplace1, '' ,$key);
    
    $s3Object = new S3Client([
        'version'     => 'latest',
        'region'      => $AWSRegion,
        'credentials' => [
            'key'    => $AWSAccessKeyId,
            'secret' => $AWSSecretAccessKey
        ],
    ]);

    $cmd = $s3Object->getCommand('GetObject', [
        'Bucket' => $bucketName,
        'Key'    => $key,
        'ResponseContentType' => 'application/octet-stream',
    ]);
    
    $request = $s3Object->createPresignedRequest($cmd, '1 hour');
    $url =  (string)$request->getUri();

    return $url;
    
}
/**
 *
 * @param array $data
 * @param number $exit
 * @return void
 *
 */
function pr($data = array(), $exit = 0){
        echo '<pre>';
            print_r($data);
        echo '</pre>';
        if($exit)
            exit;
    
}
    
/**
 *
 * @param string $urlS3
 * @return array
 */
function getKeyAndBucketS3FromUrl($url = ''){
    if(empty($url)){
        return [];
    }
    //get region from .env
    $region = env("AWS_REGION", "ap-northeast-1");
    if (strpos($url, '.'.$region) === false) {
        return [];
    }
    $url = str_replace([
        'http://',
        'https://'
    ], '', $url);
    $urlExplode = explode('.s3.'.$region.'.amazonaws.com/', $url);
    return [
        'bucket' => $urlExplode[0],
        'key' => $urlExplode[1]
    ];
    return $data;
}
function downloadFileFromAmazon($folder = '',$bucketKey = array()){
    $s3Path = base_path('app/Services/aws/aws-autoloader.php');
    pr($folder);
    $s3Client = new S3Client([
        'version'     => 'latest',
        'region'      => env("AWS_REGION", "ap-northeast-1"),
        'credentials' => [
            'key'    => env('AWS_KEY'),
            'secret' => env('AWS_SECRET')
        ],
    ]);
    $s3Client->getObject(array(
        'Bucket' => $bucketKey['bucket'],
        'Key'    =>  $bucketKey['key'],
        'SaveAs' => $folder
    ));
    //require_once $s3Path;
}
// Here the magic happens :)
function zipData($source, $destination) {
    set_time_limit(0);
    ini_set('memory_limit','1024M');
    if (extension_loaded('zip')) {
        if (file_exists($source)) {
            $zip = new ZipArchive();
            if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                $source = realpath($source);
                if (is_dir($source)) {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source),  RecursiveIteratorIterator::LEAVES_ONLY);
                    foreach ($files as $name => $file)
                    {
                        // Skip directories (they would be added automatically)
                        if (!$file->isDir())
                        {
                            // Get real and relative path for current file
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($source) + 1);
                            // Add current file to archive
                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                } else if (is_file($source)) {
                    $zip->addFromString(basename($source), file_get_contents($source));
                }
            }
            return $zip->close();
        }
    }
    return false;
}
function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
        
        if (!$dir_handle)
            return false;
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname."/".$file))
                        unlink($dirname."/".$file);
                        else
                            delete_directory($dirname.'/'.$file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
}
function portfolioStyle($styles, $styleCondition = array()){
    $styleArr = [
        1 => [
            'text' => '実写',
            'bg' => '#212122', //#3A01DF
            'color' => '#FFFFFF'
        ],
        2 => [
            'text' => 'アニメ',
            'bg' => '#60bfb3',//#7f1a74
            'color' => '#FFFFFF' 
        ]
    ];
    
    if(empty($styleCondition)){
        $allStyle = false;
        if( !empty($styles) ){
            foreach($styles as $style){
                if($style->style_id == 3){
                    $allStyle = true;
                    break;
                }
                
            }
        }
        if($allStyle){
            foreach($styleArr as $style){
                echo '<span style="color:'.$style['color'].';background-color:'.$style['bg'].'">'.$style['text'].'</span>';
            }
        }else{
            foreach($styles as $style){
                if( isset( $styleArr[$style->style_id] ) ){
                    echo '<span style="color:'.$styleArr[$style->style_id]['color'].';background-color:'.$styleArr[$style->style_id]['bg'].'">'.$styleArr[$style->style_id]['text'].'</span>';
                }
            }
        }
    }else{ //post
        if(count( $styleCondition ) == 1){
            if($styleCondition[0] ==3){
                foreach($styleArr as $style){
                    echo '<span style="color:'. $style['color'].';background-color:'.$style['bg'].'">'.$style['text'].'</span>';
                }
            }else{
                $s = $styleCondition[0];
                echo '<span style="color:'.$styleArr[$s]['color'].';background-color:'.$styleArr[$s]['bg'].'">'.$styleArr[$s]['text'].'</span>';
            }
            
        }else{
            
            if(count($styles) == 1 && $styles[0]->style_id ==3){
                foreach($styleArr as $style){
                    echo '<span style="color:'. $style['color'].';background-color:'.$style['bg'].'">'.$style['text'].'</span>';
                }
            }else{
                
                foreach($styles as $style){
                    if( isset( $styleArr[$style->style_id] ) && in_array($style->style_id,$styleCondition) ){
                        echo '<span style="color:'.$styleArr[$style->style_id]['color'].';background-color:'.$styleArr[$style->style_id]['bg'].'">'.$styleArr[$style->style_id]['text'].'</span>';
                    }
                }
            }
        }
    }
}

function createUrlAvatar($url){

    if(empty($url)){
        return '';
    }

    if(starts_with($url,'http')){
        return $url;
    }

    return 'https://'.env('AWS_BUCKET', 'crluo-dev').'.s3.'.env('AWS_REGION', 'ap-northeast-1').'.amazonaws.com/'.$url;

}
