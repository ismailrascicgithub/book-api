<?php

require_once __DIR__ . '/../CommonModel.php';
require_once __DIR__ . '/../interfaces/Searchable.php';
class Book extends CommonModel implements Searchable
{
    protected $table = 'books';
    protected $searchableFields = ['title', 'author'];

    public $id;
    public $title;
    public $author;
    public $published_year;
    public $genre;

    public function search($searchTerm)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
        $params = [];

        if ($searchTerm && !empty($this->searchableFields)) {
            $searchConditions = [];
            foreach ($this->searchableFields as $field) {
                $searchConditions[] = "$field LIKE :$field";
                $params[":$field"] = "%$searchTerm%";
            }
            $query .= " AND (" . implode(" OR ", $searchConditions) . ")";
        }

        return ['query' => $query, 'params' => $params];
    }
}
