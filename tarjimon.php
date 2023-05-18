<?php

$admin = '848796050'; // Admin ID
$token = '5489665113:AAH_mbcsEwN5U6jeXQvWaXqFUeto-SYYl5c';  //Bot token

function bot($method,$datas=[]){
global $token;
$url = "https://api.telegram.org/bot".$token."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}
function getmore($text){
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, "https://api.dictionaryapi.dev/api/v2/entries/en/".urlencode($text));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $result = json_decode($result);
    curl_close($curl);
    if ($result->title){
        return false;
    }
    return $result[0];

}

function translate($text, $in, $out) {
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=$out&dt=t&q=".urlencode($text));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $result = json_decode($result);
    curl_close($curl);

    if (isset($result[0][0][0])) {
        return $result[0][0][0];
    } else {
        return false;
    }
}

function translate_sentences($text, $in, $out) {
    // $sentences = preg_split('/(?<=\.|\!|\?|\:|\;|\-)\s+/', $text);
    // $sentences = preg_split('/(?<=[.!?;:-])\s+|\n+/', $text);
    $sentences = preg_split('/(?<=[(12)|(13)|(14)|(15)|(16)|(17)])\s+|\n+/', $text);

    $translated = array();

    foreach ($sentences as $sentence) {
        $translation = translate($sentence, $in, $out);
        if ($translation !== false) {
            $translated[] = $translation;
        } else {
            $translated[] = $sentence;
        }
    }

    return implode(' ', $translated);
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message ?? null;
$callbackquery = $update->callback_query ?? null;
$text = $message->text ?? null;
$name = $message->from->first_name ?? null;
$from_id = $message->from->id ?? null;
$cid = $message->chat->id ?? null;
$type = $message->chat->type ?? null;
$mid = $message->message_id ?? null;
$start_text = "Assalomu alaykum men rasm, video, file va matnlarni tarjima qilib beraman!";
if(isset($message->text)){
    if ($text == "/start") {
    $users_file = "users.txt";
    $existing_users = [];
    if (file_exists($users_file)) {
        $existing_users = explode("\n", file_get_contents($users_file));
        $existing_users = array_map('trim', $existing_users);
    }

    if (in_array($from_id, $existing_users)) {
    } else {
        file_put_contents($users_file, $from_id . "\n", FILE_APPEND);
    }
    bot('sendMessage', [
        'chat_id' => $cid,
        'text' => "<i>$start_text</i>",
        'parse_mode' => 'html',
    ]);
    }elseif ($text == "/uz" or $text == "/ru" or $text == "/en"){
        bot('sendmessage',[
            'chat_id'=>$cid,
            'text'=>"<i>tarjima qilinmoqda biroz kuting...</i>",
            'parse_mode'=>'html',
        ]);
        $data = explode("<=>", file_get_contents("sozlar/$cid.text"));
        $type = $data[0];
        $word = $data[1];
        $out = str_replace("/", "", $text);
        $res = translate_sentences($word, 'auto' , $out );
        $res = unreplace($res);
        bot('deletemessage',[
            'chat_id'=>$cid,
            'message_id'=>$mid+1
        ]);
        if (strlen($res) > 1024){
            $type = "text";
        }
        if($type == "text"){
            bot('sendmessage',[
                'chat_id'=>$cid,
                'text'=>$res,
                'parse_mode'=>'html',
            ]);

        }elseif($type == "photo"){
            bot('sendphoto', [
                'photo' => $data[2],
                'chat_id' => $cid,
                'caption' => $res,
                'parse_mode' => 'html',
            ]);
        }elseif($type == "video"){
            bot('sendvideo', [
                'video' => $data[2],
                'chat_id' => $cid,
                'caption' => $res,
                'parse_mode' => 'html',
            ]);
        }elseif($type == "document"){
            bot('senddocument', [
                'document' => $data[2],
                'chat_id' => $cid,
                'caption' => $res,
                'parse_mode' => 'html',
            ]);
        }
    }elseif($text == "/stat" and $cid == $admin){
        $userlar = file_get_contents("users.txt");
        $count = substr_count($userlar,"\n");
        $member = count(file("users.txt"))-1;
        bot('sendmessage',[
            'chat_id'=>$cid,
            'text'=>"Bot azolari soni: {$member}-ta",
            'parse_mode'=>'html',
        ]);
    }else{
        $resp = "Qaysi tilga tarjima qilasiz?\n\n/uz,  /ru,  /en";
               
        $new_text = replace($text);        
        
        bot('sendmessage',[
            'chat_id'=>$cid,
            'text'=>$resp,
            'parse_mode'=>'html',
        ]);
        

        file_put_contents("sozlar/$cid.text", "text<=>".$new_text);
    }


}elseif(isset($message->photo)){
    $photo_id = $message->photo[count($message->photo)-1]->file_id;
    $caption = $message->caption;
    // bot('sendmessage',[
    //     'chat_id'=>$cid,
    //     'text'=>$photo_id,
    //     'parse_mode'=>'html',
    // ]);
    // exit();
    $resp = "Qaysi tilga tarjima qilasiz?\n\n/uz,  /ru,  /en";
    bot('sendmessage',[
        'chat_id'=>$cid,
        'text'=>$resp,
        'parse_mode'=>'html',
    ]);
    $new_text = replace($caption);        
    
    file_put_contents("sozlar/$cid.text", "photo<=>".$new_text."<=>{$photo_id}");

}
elseif(isset($message->video)){
    $video_id = $message->video->file_id;
    $caption = $message->caption;
    $resp = "Qaysi tilga tarjima qilasiz?\n\n/uz,  /ru,  /en";
    bot('sendmessage',[
        'chat_id'=>$cid,
        'text'=>$resp,
        'parse_mode'=>'html',
    ]);
    $new_text = replace($caption);        

    file_put_contents("sozlar/$cid.text", "video<=>".$new_text."<=>{$video_id}");

}elseif(isset($message->document)){
    $document_id = $message->document->file_id;
    $caption = $message->caption;
    $resp = "Qaysi tilga tarjima qilasiz?\n\n/uz,  /ru,  /en";
    bot('sendmessage',[
        'chat_id'=>$cid,
        'text'=>$resp,
        'parse_mode'=>'html',
    ]);
    $new_text = replace($caption);        

    file_put_contents("sozlar/$cid.text", "document<=>".$new_text."<=>{$document_id}");
}
// bot('sendmessage', [
//     'chat_id' => $cid,
//     'text' => json_encode($message),
//     'parse_mode' => 'html',
// ]);


function replace($text){
    $replacements = array(
        '.' => '(12)',
        ',' => '(13)',
        '?' => '(14)',
        '!' => '(15)',
        ':' => '(16)',
        ';' => '(17)' ,
        "\n" => '(18)',
        // "-" => ' ~19 ',
    );
    $new_text = str_replace(array_keys($replacements), array_values($replacements), $text);
    return $new_text;
}
function unreplace($text){
    $replacements = array(
        '(12)' => '.',
        '(13)' => ',',
        '(14)' => '?',
        '(15)' => '!',
        '(16)' => ':',
        '(17)' => ';',
        "(18)" => "\n",
        // " ~19 " => "-",

    );

    $res = str_replace(array_keys($replacements), array_values($replacements), $text);
    return $res;
}
?>


