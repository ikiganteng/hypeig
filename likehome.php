<?php
error_reporting(0);
//ikiganteng
set_time_limit(0);
date_default_timezone_set('UTC');

require __DIR__ . '/vendor/autoload.php';
function getVarFromUser($text)
{
    echo $text . ': ';
    $var = trim(fgets(STDIN));
    return $var;
}

/////// CONFIG ///////
//$username = 'usernamelu!';
//$password = 'passwordlu!';
$debug = false; // untuk mengecek ubah ke true
$truncatedDebug = false;
$mycount = 0;
$homecount = 0;
//////////////////////

$climate = new \League\CLImate\CLImate();
$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
$climate->green()->bold(
    "
   __ __              ____    
  / // /_ _____  ___ /  _/__ _
 / _  / // / _ \/ -_)/ // _ `/
/_//_/\_, / .__/\__/___/\_, / 
     /___/_/           /___/  
"
);
$climate->out('');
$climate->green()->bold('BOT Instagram');
$climate->green()->bold('Like Home');
$climate->green()->bold('v1.2'); // menambah kecepatan & menambah delay bypass limits
$climate->out('');
$climate->green('© Developed by IKIGANTENG (https://github.com/ikiganteng)');
$climate->out('');
$climate->out('Please provide login data of your Instagram Account.');
    $username = getVarFromUser('Login');
    if (empty($username)) {
        do {
            $login = getVarFromUser('Login');
        } while (empty($username));
    }
    sleep(1);
    $password = getVarFromUser('Password');
    if (empty($password)) {
        do {
            $password = getVarFromUser('Password');
        } while (empty($password));
    }
$sleep = getVarFromUser('Sleep (3600)');
    if (empty($sleep)) {
        do {
            $sleep = getVarFromUser('Sleep (3600)');
        } while (empty($sleep));
    }

try {
    $ig->login($username, $password);
   }catch (\Exception $e){
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}
    $climate->infoBold('Logged as @' . $username . ' successfully.');
	  $climate->out('');

while(true){
    try {
    $feed = $ig->timeline->getTimelineFeed();
    $itemsJson = json_decode($feed);
	  $ikiganteng = 9;
    $counsa = 100 % $ikiganteng;
	  $vprocess = $climate->progress()->total(($counsa * $ikiganteng));
	  do {
    $vprocess->advance(floor($counsa), 'Collecting feed from home @'.$username);
    sleep(1);
    $ikiganteng -= 1;
    } while (0 != $ikiganteng);
    $climate->info('feed home collected.');
	  $climate->out('');
    $homecount++;
    $items = $itemsJson->feed_items;
    foreach ($items as $item) {
    $mediaFeed = $item->media_or_ad;
    $media_id = $mediaFeed->id;    
    //file_put_contents("feed.txt", json_encode(array('id' => $mediaid)));
    //$cek = file_get_contents("feed.txt");
    //$cek = json_decode($cek);
    //$media_id = $cek->id;
    try{
    $resp = $ig->media->like($media_id,1);
    } catch (\InstagramAPI\Exception\FeedbackRequiredException $e) {
    $climate->darkGray('FeedbackRequired ! Resting during 6 hours before try again.');
    sleep(6*3600);
    }
    $response = json_decode($resp);
    if ($response->status == 'ok') {
    $mycount++;
    $climate->cyan(date('H:i:s') .  ' - Media_id : ' . $media_id . ' Likes Given: ' . $mycount . ' Total Get Home : ' . $homecount);
    }else{
    $climate->error(date('H:i:s') .' - Fail to like ');
    }
    $counter3 = rand(40, 60) + rand(1, 9); // jgn < ajg
    $climate->darkGray('Starting ' . $counter3 . ' second(s) delay for bypassing Instagram limits.');
    $vProgress = $climate->progress()->total($counter3);
    do{
    $vProgress->advance(1, $counter3. 'second(s) left');
    sleep(1);
    $counter3 -= 1;
    } while (0 != $counter3);
    }
	  $climate->out('');
    $climate->error('Starting ' . $sleep . ' second(s) delay for sleep.');
    $vProgress = $climate->progress()->total($sleep);
    do {
    $vProgress->advance(1, $sleep. 'second(s) left');
    sleep(1);
    $sleep -= 1;
    } while (0 != $sleep);
    $climate->out('');
    } catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    }
}
