<?php

class StatusRepository extends DbRepository
{
    public function insert($user_id)
    {
        $now = new DateTime();

        $sql = "
            insert into status(user_id, created_at)
                values(:user_id, :created_at)
        ";

        $stmt = $this->execute($sql, array(
            ':user_id' => $user_id,
            ':created_at' => $now->format('Y-m-d H:i:s'),
        ));
    }

    public function fetchAllPersonArchivesByUserId($user_id)
    {
        $sql = "
            select a.*, u.mailaddress
                from status a
                    left join user u on a.user_id = u.id
                where u.id = :user_id
                order by a.created_at desc
        ";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }

    public function fetchAllByUserId($user_id)
    {
        $sql = "
            select a.*, u.mailaddress
                from status a
                    left join user u on a.user_id = u.id
                where u.id = :user_id
                order by a.created_at desc
        ";
    }

    public function fetchByIdAndUserName($id, $mailaddress)
    {
        $aql = "
            select a.*, u.mailaddress
                from status a
                    left join user u on u.id = a.user_id
                where a.id = :id
                    and u.mailaddress = :mailaddress
        ";

        return $this->fetch($sql, array(
            ':id' => $id,
            ':mailaddress' => $mailaddress,
        ));
    }
}
