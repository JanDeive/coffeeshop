<?php
namespace App\Models;

use App\Helpers\Database;
use PDO;

class CoffeeShopModel
{
    protected static $db = null;
    protected $table;
    protected $attributes = [];
    protected $primaryKey;

    public function __construct($table = null)
    {
        if (self::$db === null) {
            self::$db = (new Database())->getConnection();
        }
        $this->table = $table;
        $this->primaryKey = $table . '_id';
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function save()
    {
        $filteredAttributes = $this->filterDatabaseColumns();

        if (isset($filteredAttributes[$this->primaryKey])) {
            return $this->update($filteredAttributes[$this->primaryKey], $filteredAttributes);
        } else {
            return $this->insert($filteredAttributes);
        }
    }

    private function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = self::$db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }

        if ($stmt->execute()) {
            $this->attributes[$this->primaryKey] = self::$db->lastInsertId();
            return true;
        }
        return false;
    }

    private function update($id, $data)
    {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

        $query = "UPDATE {$this->table} SET $setClause WHERE {$this->primaryKey} = :id";
        $stmt = self::$db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    public function delete()
    {
        $id = $this->{$this->primaryKey};

        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    private function getDatabaseColumns()
    {
        $query = "DESCRIBE {$this->table}";
        $stmt = self::$db->prepare($query);
        $stmt->execute();

        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'Field');
    }

    private function filterDatabaseColumns()
    {
        $dbColumns = $this->getDatabaseColumns();
        return array_filter(
            $this->attributes,
            fn($key) => in_array($key, $dbColumns),
            ARRAY_FILTER_USE_KEY
        );
    }

    public static function findAll()
    {
        $instance = new static();
        $query = "SELECT * FROM {$instance->table}";
        $stmt = self::$db->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($result) use ($instance) {
            $newInstance = new static();
            $newInstance->mapColumnsToAttributes($result);
            return $newInstance;
        }, $results);
    }

    public static function find($id)
    {
        $instance = new static();
        $query = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $instance->mapColumnsToAttributes($result);
            return $instance;
        }
        return null;
    }

    private function mapColumnsToAttributes($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function addProduct($name, $price, $stock)
    {
        $this->attributes = [
            'name' => $name,
            'price' => $price,
            'stock' => $stock
        ];
        return $this->save();
    }

    public static function getProducts()
    {
        return static::findAll();
    }

    public function placeOrder($productId, $quantity, $customerId)
    {
        $this->attributes = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'customer_id' => $customerId,
            'order_date' => date('Y-m-d H:i:s')
        ];
        return $this->save();
    }

    public function addCustomer($name, $email)
    {
        $this->attributes = [
            'name' => $name,
            'email' => $email
        ];
        return $this->save();
    }

    public static function getCustomers()
    {
        return static::findAll();
    }
}
