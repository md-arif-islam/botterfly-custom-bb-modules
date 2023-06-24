<?php
@ini_set('zlib.output_compression',0);
@ini_set('implicit_flush',1);
@ob_end_clean(); 



header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Content-Encoding: none');


// Check if the parameter exists and if it's not empty
function checkParam($paramName) {
    if (isset($_GET[$paramName]) && !empty($_GET[$paramName])) {
        return $_GET[$paramName];
    } else {
        return false;
    }
}

// Get all parameters
$letter = checkParam('letter');
$wnym = checkParam('wnym');
$cyt = checkParam('cyt');
$cc = checkParam('cc');
$aoe = checkParam('aoe');
$pt = checkParam('pt');
$pgas = checkParam('pgas');

$prompt = "I am tasked with writing a letter. \n";

// Only add to the prompt if the parameter is not false
if ($letter) $prompt .= "The content of the letter should be: $letter. \n";
if ($wnym) $prompt .= "The reason why I am writing the letter is: $wnym. \n";
if ($cyt) $prompt .= "This letter is intended to convey: $cyt. ";
if ($cc) $prompt .= "I should keep in mind that the recipient cares about: $cc. \n";
if ($aoe) $prompt .= "The area of expertise required for this letter is: $aoe. \n";
if ($pt) $prompt .= "The preferred tone for this letter is: $pt. \n";
if ($pgas) $prompt .= "The recipient prefers the greeting as: $pgas. \n";



$endpoint = 'https://api.openai.com/v1/chat/completions';
$api_key = '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';


$data = array(
    'model' => 'gpt-3.5-turbo',
    'stream' => true,
    'messages' => array(
        array(
            'role' => 'user',
            'content' => $prompt,
        ),
    ),
);

$json = json_encode($data);

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
));

// Set CURLOPT_WRITEFUNCTION to process stream data
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {

    // The function must return the number of bytes taken care of.
    // If this amount differs from the amount passed in to the function, cURL will signal an error.
    echo $data.str_repeat(' ',1024*8);
    return strlen($data);
    
});

$response = curl_exec($ch);

if($response === false)
{
    echo 'Curl error: ' . curl_error($ch);
}

curl_close($ch);