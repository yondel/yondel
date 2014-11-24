<?php

class UserRepository extends DbRepository
{
    public function insert($mailaddress, $password)
    {
        $password = $this->hashPassword($password);
        $now = new DateTime();

        $sql = "
            insert into user(mailaddress, password, created_at)
            values(:mailaddress, :password, :created_at)
        ";

        $stmt = $this->execute($sql, array(
             ':mailaddress' => $mailaddress,
             ':password'    => $password,
             ':created_at'  => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function hashPassword($password)
    {
        return sha1($password . '4nKNi302NUkan');
    }

    public function fetchByUserName($mailaddress)
    {
        $sql = "select * from user where mailaddress = :mailaddress";

        return $this->fetch($sql, array(':mailaddress' => $mailaddress));
    }

    public function isUniqueUserName($mailaddress)
    {
        $sql = "select count(id) as count from user where mailaddress = :mailaddress";

        $row = $this->fetch($sql, array(':mailaddress' => $mailaddress));
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }
}
