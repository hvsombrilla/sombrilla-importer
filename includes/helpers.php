<?php

function getYoutubeIDByKey($string)
{
    $DEVELOPER_KEY = get_option('si-google-key', '');
    $url           = "https://www.googleapis.com/youtube/v3/search?part=id&q=" . $string . "&maxResults=1&key=" . $DEVELOPER_KEY;
    $data          = Requests::get($url)->body;
    $data = json_decode($data);

    return ($data->items[0]->id->videoId) ? $data->items[0]->id->videoId:'';
}

/**
 * Return the url of first Google Image result
 * @string type $string 
 * @return type
 */

function getGoogleImageByKey($string){
	$string = urlencode($string);
    $cx = '007514226657487451361:orhbjyttrwy';
    $key = get_option('si-google-key', '');
    $searchType = 'image';
    $imgSize = 'large';
    $imgType ='news';
    $offset = 1;
    $results = 1; // Máx: 10
    $filter = 1; // Duplicate content filter

    $return = json_decode(file_get_contents('https://www.googleapis.com/customsearch/v1?q='.$string.'&filter='.$filter.'&imgType='.$imgType.'&gl=es&num='.$results.'&start='.$offset.'&searchType='.$searchType.'&key='.$key.'&cx='.$cx));

    return $return->items[0]->link; 
}
