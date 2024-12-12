<?php
namespace App\Models;

use \PDO;

class CoffeeShop extends Model {

    public function __construct() {
        parent::__construct('coffee_shop');  // 'coffee_shop' is the table name
        $this->primaryKey = 'shop_id';

        // Define validation rules
        $this->setRules([
            'name' => ['required' => true, 'maxLength' => 255],
            'address' => ['required' => true, 'maxLength' => 500],
            'email' => ['required' => true, 'email' => true],
        ]);
    }

    // Add specific method for adding new coffee shop
    public function addShop($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this->save();
    }

    // Add specific method for updating coffee shop information
    public function updateShop($id, $data) {
        $shop = self::find($id);
        if ($shop) {
            foreach ($data as $key => $value) {
                $shop->$key = $value;
            }
            return $shop->save();
        }
        return false;  // Shop not found
    }

    // Add specific method for retrieving all coffee shops
    public static function getAllShops() {
        return self::findAll();
    }

    // Add specific method for retrieving a coffee shop by ID
    public static function getShopById($id) {
        return self::find($id);
    }

    // Add specific method for deleting a coffee shop
    public function deleteShop($id) {
        $shop = self::find($id);
        if ($shop) {
            return $shop->delete();
        }
        return false;  // Shop not found
    }

    // Add specific method to search coffee shops by name
    public static function searchShopsByName($name) {
        $query = "SELECT * FROM coffee_shop WHERE name LIKE :name";
        $stmt = self::$db->prepare($query);
        $searchTerm = "%$name%";
        $stmt->bindParam(':name', $searchTerm);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
