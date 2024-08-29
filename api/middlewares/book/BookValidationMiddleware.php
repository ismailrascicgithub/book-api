<?php
class BookValidationMiddleware
{
    public function handle($input)
    {
        if (empty($input['title']) || !is_string($input['title'])) {
            Response::send(400, ["message" => "Title is required and must be a string."]);
            exit();
        }

        if (empty($input['author']) || !is_string($input['author'])) {
            Response::send(400, ["message" => "Author is required and must be a string."]);
            exit();
        }

        if (empty($input['published_year']) || !is_numeric($input['published_year']) || strlen($input['published_year']) != 4) {
            Response::send(400, ["message" => "Published year is required and must be a 4-digit year."]);
            exit();
        }

        if (empty($input['genre']) || !is_string($input['genre'])) {
            Response::send(400, ["message" => "Genre is required and must be a string."]);
            exit();
        }
    }
}
