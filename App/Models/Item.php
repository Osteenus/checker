<?php

namespace App\models;

use App\components\Db;
use PDO;

/**`
 * Class Item - model for working with items of list
 */
class Item
{
    public static function getItemsByListId(int $id):array
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM items WHERE list_id = :list_id';

        $result = $db->prepare($sql);
        $result->bindParam(':list_id', $id, PDO::PARAM_INT);
        $result->execute();

        $i = 0;
        $items = array();
        while ($row = $result->fetch()) {
            $items[$i]['id'] = (string)$row['id'];
            $items[$i]['text'] = (string)$row['text'];
            $items[$i]['list_id'] = (string)$row['list_id'];
            $items[$i]['is_checked'] = (string)$row['is_checked'];
            $items[$i]['unit_id'] = (string)$row['unit_id'];
            $items[$i]['quantity'] = (string)$row['quantity'];
            $items[$i]['created_at'] = (string)$row['created_at'];
            $items[$i]['updated_at'] = (string)$row['updated_at'];
            $i++;
        }
        return $items;
    }

    public static function create(int $itemsListId, $item):int
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO items (text, list_id, is_checked, unit_id, quantity, created_at)
                VALUES (:text, :list_id, :is_checked, :unit_id, :quantity, :created_at)';
        $result = $db->prepare($sql);
        $result->bindParam(':text', $item['text']);
        $result->bindParam(':list_id', $itemsListId, PDO::PARAM_INT);
        $result->bindParam(':is_checked', $item['is_checked'], PDO::PARAM_BOOL);
        $result->bindParam(':unit_id', $item['unit_id'], PDO::PARAM_INT);
        $result->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
        $date = date('Y-m-d H:i:s');
        $result->bindParam(':created_at', $date);

        if ($result->execute()) {
            return $db->lastInsertId();
        }
        return 0;
    }

    /**
     * @param array $item
     * @return int
     */
    public static function update(array $item):int
    {
        $db = Db::getConnection();
        $sql = 'UPDATE items SET text = :text, list_id = :list_id, is_checked = :is_checked, unit_id = :unit_id, quantity = :quantity, updated_at = :updated_at
                WHERE id = :id
                RETURNING text, list_id, is_checked, unit_id, quantity, updated_at';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $item['id']);
        $result->bindParam(':text', $item['text']);
        $result->bindParam(':list_id', $item['list_id'], PDO::PARAM_INT);
        $result->bindParam(':is_checked', $item['is_checked'], PDO::PARAM_BOOL);
        $result->bindParam(':unit_id', $item['unit_id'], PDO::PARAM_INT);
        $result->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
        $date = date('Y-m-d H:i:s');
        $result->bindParam(':updated_at', $date);

        if ($result->execute()) {
            return 1;
        }
        return 0;
    }

    public static function destroy(int $id):int
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM items WHERE id = :id RETURNING *';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        if ($result->execute()) {
            return $result->execute();
        }
        return 0;
    }

}
