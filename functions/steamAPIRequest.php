<?php
function getUserInfo($steamId){
    $ch = curl_init("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=41E51F7C0B7DDE85462226C6826E661C&steamids=$steamId");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getUserInfoOtherKey($steamId){
    $ch = curl_init("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=D52B784A612ADB1197D04427D3193E8E&steamids=$steamId");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getUserFriends($steamId){
    $ch = curl_init("http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=41E51F7C0B7DDE85462226C6826E661C&steamid=$steamId&relationship=friend");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getPlayerLevel($steamid){
    $ch = curl_init("https://api.steampowered.com/IPlayerService/GetSteamLevel/v1/?key=41E51F7C0B7DDE85462226C6826E661C&format=json&steamid=$steamid");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getUserOwnedGames($steamId){
    $ch = curl_init("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=41E51F7C0B7DDE85462226C6826E661C&steamid=$steamId&format=json");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getUserOwnedGamesOtherKey($steamId){ /* I need to use the same request with an other key for privacy setting checking, see generalFunctions for more details */ 
    $ch = curl_init("http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=D52B784A612ADB1197D04427D3193E8E&steamid=$steamId&format=json");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getRecentlyPlayedGames($steamId){
    $ch = curl_init("https://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v1/?key=41E51F7C0B7DDE85462226C6826E661C&format=json&steamid=$steamId");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;
}

function getGameInfos($appid){
    $ch = curl_init("http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=41E51F7C0B7DDE85462226C6826E661C&appid=$appid");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;    
}

function getGameAchievements($appid){
    $ch = curl_init("http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=41E51F7C0B7DDE85462226C6826E661C&appid=$appid");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded["game"]; 
}

function getPlayerAchievementsOnGame($steamid, $appid){
    $ch = curl_init("https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v2/?key=41E51F7C0B7DDE85462226C6826E661C&format=json&steamid=$steamid&appid=$appid");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $decoded = json_decode($data, true); //will return an object (if I use true as the second parameter, it'll return an associative array) 
    return $decoded;    
}