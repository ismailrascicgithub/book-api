<?php
require_once __DIR__ . '/../CommonController.php';
require_once __DIR__ . '/../../models/book/Book.php';

class BookController extends CommonController {
    public function __construct() {
        parent::__construct(Book::class);
    }

    public function getBooks() {
        $this->getAll();
    }

    public function getBook($id) {
        $this->getById($id);
    }

    public function addBook($input) {
        $this->add($input);
    }

    public function updateBook($id, $input) {
        $this->update($id, $input);
    }

    public function deleteBook($id) {
        $this->delete($id);
    }
}
