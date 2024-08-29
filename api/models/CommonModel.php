<?php
class CommonModel
{
    protected $conn;
    protected $table;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public static function getAll($page = 1, $limit = 10, $search = null)
    {
        $instance = new static();
        $db = $instance->conn;
        $offset = ($page - 1) * $limit;

        if ($instance instanceof Searchable && $search) {
            $searchResult = $instance->search($search);
            $query = $searchResult['query'] . " LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($query);

            foreach ($searchResult['params'] as $key => $value) {
                $stmt->bindParam($key, $value);
            }
        } else {
            $query = "SELECT * FROM " . $instance->table . " LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($query);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTotalCount($search = null)
    {
        $instance = new static();
        $db = $instance->conn;
        $query = "SELECT COUNT(*) as total FROM " . $instance->table . " WHERE 1=1";

        if ($search) {
            $query .= " AND (title LIKE :search OR author LIKE :search)";
        }

        $stmt = $db->prepare($query);

        if ($search) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function findById($id)
    {
        $instance = new static();
        $db = $instance->conn;
        $query = "SELECT * FROM " . $instance->table . " WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        if ($this->id) {
            $query = "UPDATE " . $this->table . " SET ";
            $fields = [];
            foreach ($this as $key => $value) {
                if ($key !== 'conn' && $key !== 'table' && $key !== 'id' && !is_array($value)) {
                    $fields[] = "$key = :$key";
                }
            }
            $query .= implode(", ", $fields);
            $query .= " WHERE id = :id";
        } else {
            $query = "INSERT INTO " . $this->table . " (";
            $fields = [];
            $placeholders = [];
            foreach ($this as $key => $value) {
                if ($key !== 'conn' && $key !== 'table' && $key !== 'id' && !is_array($value)) {
                    $fields[] = $key;
                    $placeholders[] = ":$key";
                }
            }
            $query .= implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
        }
    
        $stmt = $this->conn->prepare($query);
    
        foreach ($this as $key => $value) {
            if ($key !== 'conn' && $key !== 'table' && ($key !== 'id' || $this->id) && !is_array($value)) {
                $stmt->bindValue(":$key", $value);
            }
        }
    
        if ($this->id) {
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        }
    
        return $stmt->execute();
    }
    

    public static function delete($id)
    {
        $instance = new static();
        $db = $instance->conn;
        $query = "DELETE FROM " . $instance->table . " WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
