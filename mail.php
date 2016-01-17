<?php
/**
 * Created by PhpStorm.
 * User: Karen Araya Milashka
 * Date: 16/01/2016
 * Time: 10:39 PM
 */


define( "URL_MAIL", "http://krayze.free.fr/Main/Mail_S.php" );

if( !empty($_POST["from"]) && !empty($_POST["to"]) && !empty($_POST["subject"]) && !empty($_POST["msg"]) )
{
    $data = array
    (
        "From"    => $_POST["from"],
        "To"      => $_POST["to"],
        "Subject" => $_POST["subject"],
        "b64File" => "",
        "Data"    => $_POST["msg"]
    );

    $boundary = "WebKitFormBoundary" . substr( md5(time()), 0, 16 );
    $body = request_payload( $data, $boundary );
    $len = strlen( $body );

    $headers = array
    (
        "Content-Length: $len",
        "Content-Type: multipart/form-data; boundary=----$boundary"
    );

    $handler = curl_init( );
    curl_setopt( $handler, CURLOPT_URL, URL_MAIL );
    curl_setopt( $handler, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $handler, CURLOPT_POST, true );
    curl_setopt( $handler, CURLOPT_POSTFIELDS, $body );
    $response = curl_exec( $handler );
    curl_close( $handler );

    echo "Success";
}
else
{
    echo "Error" ;
}

function request_payload( $data, $boundary )
{
    $prefix = "------$boundary";
    $str = "";

    foreach( $data as $key => $value )
    {
        $str .= "$prefix\r\n";
        $str .= "Content-Disposition: form-data; name=\"$key\"";

        if( $key == "b64File" )
        {
            $str .= "; filename=\"\"\r\n";
            $str .= "Content-Type: application/octet-stream";
        }

        $str .= "\r\n\r\n$value\r\n";
    }

    $str .= "------$boundary--";
    return $str;
}