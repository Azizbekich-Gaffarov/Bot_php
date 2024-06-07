<?php 

//Ulanishlar va shartli belgilar 
date_default_timezone_set('Asia/Tashkent'); 
include 'Telegram.php'; 
$bot_token = '6943458877:AAG_hGQHg7lNn21CyNGL_uB0abAw7vQRLZ0'; 
$telegram = new Telegram($bot_token); 
$text = $telegram->Text(); 
$chat_id = $telegram->ChatID(); 
$ism = $telegram->FirstName(); 
$mid = $telegram->MessageID(); 
$admin="#";
//Start 
if ($text == '/start') { 
  $action = ['chat_id' => $chat_id, 'action' => 'typing']; 
  $telegram->sendChatAction($action); 
  $option = []; 
  $keyb = $telegram->buildKeyBoard($option, $onetime = false); 
  $content = ['chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Salom $ism zerikdingizmi unda men bilan suxbatlashing. Meni guruxlarga qoshsangiz yanada xursand bolardim."]; 
  $telegram->sendMessage($content); 
} 

//Salomlarga javob berish 
$texts = array('Sizgaham salom', 'Assalomu alykum','Salom kayfiyatingiz qalay', 'Salom alekum qalaysiz');  
$send = $texts[rand(0, count($texts) - 1)]; 

if ($text == 'Salom' || $text == 'Qalaysiz') { 
  $action = ['chat_id' => $chat_id, 'action' => 'typing']; 
  $telegram->sendChatAction($action); 
  $reply = "$send"; 
  $content = ['chat_id' => $chat_id, 'reply_to_message_id' => $mid, 'text' => $reply]; 
  $telegram->sendMessage($content); 
} 


//Bazaga yangi savol qoshish 
if(mb_stripos($text,"/add") !== false && $chat_id==$admin){ 
  $loop = explode(">", $text); 
  $suz = $loop[1]; 
  $javob = $loop[2]; 
  $filed = "baza/{$suz}.txt"; 
  $rez = "$javob"; 
  file_put_contents($filed, $rez); 
  
  $tex="📎 Savol qoshildi! 
  🔒 Savol: $suz 
  🔑 Javob: $javob"; 
  $content = ['chat_id' => $chat_id, 'reply_to_message_id' => $mid, 'text' => $tex]; 
  $telegram->sendMessage($content); 
  $telegram->ai($suz,$javob);
} 
if($text!==false){ 
  $action = ['chat_id' => $chat_id, 'action' => 'typing']; 
  $telegram->sendChatAction($action); 
  $gap = file_get_contents("baza/{$text}.txt"); 
  $content = ['chat_id' => $chat_id, 'reply_to_message_id' => $mid, 'text' => $gap]; 
  $telegram->sendMessage($content); 
} 

$d = date('H:i:s'); 

if ($text == 'Soat nechchi?') { 
  $reply = "Soat: $d boldi. Sizga yordam berganimdan xursandman! 🤗"; 
  $content = ['chat_id' => $chat_id, 'reply_to_message_id' => $mid, 'text' => $reply]; 
  $telegram->sendMessage($content); 
} 

$a = date('d:m:Y'); 

if ($text == 'Sana nechchi?') { 
  $reply = "Bugun sana: $a Sizga yordam berganimdan xursandman! 🤗"; 
  $content = ['chat_id' => $chat_id, 'reply_to_message_id' => $mid, 'text' => $reply]; 
  $telegram->sendMessage($content); 
} 
?>