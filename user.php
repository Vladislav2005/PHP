<?php

require_once("db.php");


class ImageService{
    public static function uploadImage(array $image, ImageInterface $imageHolder){
    $filename = date("Y-m-d_H-i-s") . "." . pathinfo($image['name']['image'], PATHINFO_EXTENSION); 
    rename($image['tmp_name']['image'], 'C:\\xampp\\htdocs\\img\\' . $filename);
    try{
        unlink($imageHolder->getImage());
    }catch(\Exception $e){}
    $imageHolder->setImage($filename);
    }
}

class Person extends User implements Savable,  ImageInterface{

    public function __construct(array $user){
        foreach($user as $field => $value){
            $this->$field = $value;
        }
    }

    public function __call($name,$args){

    }
    public function __destruct(){

    }
    public function edit(array $user):self{
        foreach($user as $field => $value){
            if(in_array($field ,["password", "image"]) && !$value){
                continue;
            }
            if($fields === "password"){
                $value = crypt($value, "randomSalt");
            }
            $this->$field = $value;
        }
        return $this;
    }

    public static function loadFromDb(string $username):self{
        $user = findUser($username, true);
        if(!$user){
            throw new \Exception("Пользователь не найден!");
        }
        $user = new self($user);
        return $user;
    }
    public $image;
    public $location;
    public $email;
    public $link;
    public const IMG_PATH = "img/";
    public function getUsername(): string{

        return $this->username;
    }

    public function setUsername(string $username){
        $this->username = $username;
        return $this;
    }

    public function getImage():string{
        return self::IMG_PATH. $this->image;
    }

    public function setImage(string $filename){
        $this->image = $filename;
    }
    public function save(): void {
        updateUser($this, $this->id);
	}
	public function delete($user){
    $query = "DELETE FROM users ";
    $query .= " WHERE id = $user->id;";

    mysqli_query(getConnection(), $query);
	}

}

abstract class User{
    public? int $id = null;
    public string $username;
    public string $password;

    
}

interface Savable{
    public function save(): void;

}

// interface Deletable{
//     public function delete();
// }

interface ImageInterface{

    public function getImage():string; 

    public function setImage(string $filename);
}