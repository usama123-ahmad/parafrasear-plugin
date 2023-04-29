<?php
header("Access-Control-Allow-Origin: *");


$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wp-load.php';



if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{
    $text = sanitize_text_field($_POST['text']);

    $flag = "is_free";
    
    if ($flag === "is_free")
    {
        
        
            if (strlen($text) === 0)
            {
                echo json_encode(array(
                    "error" => "Empty Input! Try entering some text in input box.",
                    "errortype" => "empty-input"
                ));
            }
            else
            {
                
                $urlEncode = urlencode($text);
                
                $url = 'https://paraphrase-free.p.rapidapi.com/';
                $body = array(
                    'text' => $urlEncode,
                    'mode' => 'm4',
                    'dest' => 'es',
                );
                $headers = array(
                    'X-RapidAPI-Host' => 'paraphrase-free.p.rapidapi.com',
                    'X-RapidAPI-Key' => '7bc99aa18dmsh37f2c8ed91328c7p14442cjsn1f449b58b077',
                    'content-type' => 'application/x-www-form-urlencoded',
                );
                
                $response = wp_remote_post( $url, array(
                    'method' => 'POST',
                    'headers' => $headers,
                    'body' => $body,
                ) );



                if ( is_wp_error( $response ) ) {
                    $error_message = $response->get_error_message();
                    // handle error
                    echo wp_kses_data($error_message);

                } else {
                    $response_body = wp_remote_retrieve_body( $response );
                    // handle response

                    echo wp_kses_data($response_body) ;
                }

            }

        
    }

}
else
{
    echo "Direct acces not allowed.";
}

