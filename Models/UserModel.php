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
}