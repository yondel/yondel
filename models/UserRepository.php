<?php

class UserRepository extends DbRepository
{
    public function insert($mailaddres, $password)
    {
        $password = $this->hashPassword($password);
        $now = new DateTime();

        $sql = "
            insert into user(mailaddres, password, created_at)
            values(:mailaddres, :password, :created_at)
        ";

        $stmt = $this->execute($sql, array(
             ':mailaddres' => $mailaddres,
             ':password'    => $password,
             ':created_at'  => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function hashPassword($password)
    {
        return sha1($password . '4nKNi302NUkan');
    }

    public function fetchByUserName($mailaddres)
    {
        $sql = "select * from user where mailaddres = :mailaddres";

        return $this->fetch($sql, array(':mailaddres' => $mailaddres));
    }

    public function isUniqueUserName($mailaddres)
    {
        $sql = "select count(id) as count from user where mailaddres = :mailaddres";

        $row = $this->fetch($sql, array(':mailaddres' => $mailaddres));
        if ($row['count'] === '0') {
            return true;
        }

        return false;
    }
}
