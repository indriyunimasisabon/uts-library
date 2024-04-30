<?php

class User
{
    public $userId;
    public $userName;
    public $collectBook = array();

    public function __construct($userId, $userName)
    {
        $this->userId = $userId;
        $this->userName = $userName;
    }

    public function addBook($bookId)
    {
        array_push($this->collectBook, $bookId);
    }

    public function removeBook($bookId)
    {
        $key = array_search($bookId, $this->collectBook);
        unset($this->collectBook[$key]);
    }

    public function getBorrowedBooks()
    {
        return $this->collectBook;
    }
}
