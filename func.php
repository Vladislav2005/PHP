<?php

define('IMG_PATH', 'img/');

     function getMax($a, $b) {

        return max($a, $b);
    }

    function find(string $key) {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return null;
    }

function findAndDelete(string $key): mixed
{
    if (!isset($_SESSION[$key])) {
        return null;
    }
    
    $result = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $result;
}
function findInSession(string $key): mixed
{
    if (!isset($_SESSION[$key])) {
        return null;
    }
    
    return $_SESSION[$key];
}


function exportToFile(string $filename, array $data,  string $format = "csv"):void {
    $file = fopen(IMG_PATH . "$filename.$format" , "w+");

    if($format === "csv"){
        fwrite($file, '"' . implode('","', array_keys(current($data))) . '",' . PHP_EOL);
    foreach($data as $row){
        fwrite($file, '"' . implode('","', $row) . '",' . PHP_EOL);
    }
    }else{
        fwrite($file, json_encode($data));

    }
    fclose($file);
    
}

// function importJson(string $filename){
//     $data = file_get_contents($filename);
// 	$users = json_decode($data, true);
//     // $userKeys = current($users);
//     // unset($userKeys['id']);
//     // var_dump($userKeys);
//     while ($user = current($users)) {
//         // var_dump(key($user), key($user));
//         // die;
//         // if(key($user) == "id"){} 
//         // else if (key($user) == "username") {
//         //     $username = current($user);}
//         // else if(key($user) == "password"){
//         //     $password = current($user);}
//         // else if(key($user) == "image"){
//         //     $image = current($user);}
//         // else if(key($user) == "email"){
//         //     $email = current($user);}
//         // else if(key($user) == "location"){
//         //     $location = current($user);}
//         // else if(key($user) == "link"){
//         //     $link = current($user);}

//         var_dump(extract($user));
//         var_dump($user);
//         //var_dump(registerFromFile($username, $password, $image, $email, $location, $link));

//         next($users);
//     }
// }

function importJson(string $filename): void
{
    $content = json_decode(file_get_contents($filename), true);
    batchUsersInsert($content);
}