<?php
class CommonController
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        $items = $this->model::getAll($page, $limit, $search);
        $totalItems = $this->model::getTotalCount($search);

        $response = [
            'page' => $page,
            'limit' => $limit,
            'totalItems' => $totalItems,
            'totalPages' => ceil($totalItems / $limit),
            'items' => $items
        ];

        Response::send(200, $response);
    }

    public function getById($id)
    {
        $item = $this->model::findById($id);

        if ($item) {
            Response::send(200, $item);
        } else {
            Response::send(404, ["message" => $this->model . " not found."]);
        }
    }

    public function add($input)
    {
        $item = new $this->model();

        foreach ($input as $key => $value) {
            if (property_exists($item, $key)) {
                $item->$key = $value;
            }
        }

        if ($item->save()) {
            Response::send(201, ["message" => $this->model . " added successfully."]);
        } else {
            Response::send(500, ["message" => "Failed to add " . $this->model . "."]);
        }
    }

    public function update($id, $input)
    {
        $item = $this->model::findById($id);

        if ($item) {
            $itemObject = new $this->model();
            $itemObject->id = $id;

            foreach ($input as $key => $value) {
                if (property_exists($itemObject, $key)) {
                    $itemObject->$key = $value ?? $item[$key];
                }
            }

            if ($itemObject->save()) {
                Response::send(200, ["message" => $this->model . " updated successfully."]);
            } else {
                Response::send(500, ["message" => "Failed to update " . $this->model . "."]);
            }
        } else {
            Response::send(404, ["message" => $this->model . " not found."]);
        }
    }

    public function delete($id)
    {
        $item = $this->model::findById($id);

        if ($item) {
            if ($this->model::delete($id)) {
                Response::send(200, ["message" => $this->model . " deleted successfully."]);
            } else {
                Response::send(500, ["message" => "Failed to delete " . $this->model . "."]);
            }
        } else {
            Response::send(404, ["message" => $this->model . " not found or already deleted."]);
        }
    }
}
