<?php

namespace App\models;

use App\Components\Db;
use PDO;

class ItemsList
{
    /**
     * @param int $userId id of user
     * @return array all lists created by user
     */
    public static function getAllListsByUser(int $userId):array
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM lists WHERE user_id = :user_id ORDER BY id';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->execute();

        $i = 0;
        $items = array();
        while ($row = $result->fetch()) {
            $items[$i]['id'] = (string)$row['id'];
            $items[$i]['title'] = $row['title'];
            $items[$i]['user_id'] = (string)$row['user_id'];
            $items[$i]['created_at'] = (string)$row['created_at'];
            $items[$i]['updated_at'] = (string)$row['updated_at'];
            $i++;
        }
        return $items;
    }

    /**
     * @param int $id
     * @return \string[][]
     */
    public static function getListById(int $id):array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM lists WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        $list = $result->fetch(PDO::FETCH_ASSOC);
        if (!$list) {
            http_response_code('400');
            return array(
                "error" => [
                    "message" => "List with such ID not found",
                ]
            );
        }
        return $list;
    }

    /**
     * @param array $data new list data
     * @return int id of the new list or 0 in case of fail
     */
    public static function create(array $data):int
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO lists (title, user_id, created_at)
                VALUES (:title, :user_id, :created_at)';
        $result = $db->prepare($sql);

        $result->bindParam(':title', $data['title']);
        $result->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $date = date('Y-m-d H:i:s');
        $result->bindParam(':created_at', $date);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    /**
     * @param int $id of updating list
     * @param array $data
     * @return int id of updated list
     */
    public static function update(array $data):int
    {
        $db = Db::getConnection();
        $sql = 'UPDATE lists SET title = :title, updated_at = :updated_at, is_done = :is_done WHERE id = :id';
        $result = $db->prepare($sql);

        $result->bindParam(':id', $data['id']);
        $result->bindParam(':title', $data['title']);
        $date = date('Y-m-d H:i:s');
        $result->bindParam(':updated_at', $date);
        $result->bindParam(':is_done', $data['is_done'], PDO::PARAM_BOOL);

        if ($result->execute()) {
            return $data['id'];
        }
        return 0;
    }

    public static function destroy(int $id):int
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM lists WHERE id = :id';
        $result = $db->prepare($sql);

        $result->bindParam(':id', $id);

        if ($result->execute()) {
            return $id;
        }
        return 0;
    }
}
