<?php

namespace App\Controllers;

use App\models\Item;
use App\Models\ItemsList;

/**
 * Controller ItemsListsController
 *
 */
class ItemsListsController
{
    protected int $userId;
    protected int $statusCode;
    protected string $message;

    public function __construct($userId = 1)
    {
        $this->userId = $userId;
    }

    /**
     * Action для страницы "Каталог товаров"
     */
    public function actionIndex():bool
    {
       $id = $this->userId;
       $lists = ItemsList::getAllListsByUser($id);

       header("Access-Control-Allow-Origin: *");
       header("Content-Type: application/json; charset=UTF-8");

       echo json_encode($lists);
       return true;
    }

    public function actionEdit(int $id):bool
    {
        $itemsList = ItemsList::getListById($id);
        $items = Item::getItemsByListId($id) ;
        $itemsList['items'] = $items;

        echo json_encode($itemsList);
        return true;
    }

    /**
     * @return bool
     */
    public function actionStore():bool
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $items = $data['items'];
        $itemsListId = ItemsList::create($data);
        foreach ($items as $index => $item) {
            $itemId = Item::create($itemsListId, $item);
            if (!$itemId) {
                return false;
            }
        };
        return true;
    }

    /**
     * @return bool
     */
    public function actionUpdate(int $listId):bool
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if(!$data) {
            return false;
        }
        $newItems = $data['items'];
        $currentItems = Item::getItemsByListId($listId);
        foreach ($currentItems as $item) {
            Item::destroy($item['id']);
        }
        foreach ($newItems as $item) {
            Item::create($listId, $item);
        }
        echo json_encode(Item::getItemsByListId($listId));
        return true;
    }

    public function actionDelete($id):bool
    {
        ItemsList::destroy($id);
        $items = Item::getItemsByListId($id);
        foreach ($items as $item) {
            Item::destroy($item['id']);
        }
        return true;
    }
}
