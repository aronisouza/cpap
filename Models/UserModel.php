<?php

class UserModel {

    public function getUserById($id){
        $read = new Read();
        $read->ExeRead('usuarios', "WHERE id={$id}");
        return $read->getResult();
    }

    public function getAllUsers() {
        $read = new Read();
        $read->ExeRead('usuarios');
        return $read->getResult();
    }

    public function createUser($data) {
        $create = new Create();
        $create->ExeCreate('usuarios', $data);
        return $create->getResult();
    }

    public function updateUser($id, $data) {
        $update = new Update();
        $update->ExeUpdate('usuarios', $data, 'WHERE id = :id', "id={$id}");
        return $update->getResult();
    }

    public function deleteUser($id) {
        $delete = new Delete();
        $delete->ExeDelete('usuarios', 'WHERE id = :id', "id={$id}");
        return $delete->getResult();
    }

    public function findByEmail($email) {
        $read = new Read();
        $read->ExeRead('usuarios', "WHERE email = :email", "email={$email}");
        $result = $read->getResult();
        return $result ? $result[0] : null;
    }

    public function login($password, $email) {
        $read = new Read();
        $read->FullRead("SELECT email,name,role FROM usuarios WHERE email = :email AND password = :password" , "email={$email}&password={$password}");
        $result = $read->getResult();
        return $result ? $result[0] : null;
    }
}