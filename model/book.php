<?php

class Book
{
    public $bookId;
    public $title;
    public $author;
    public $year;
    public $status;

    function __construct($bookId, $title, $author, $year, $status)
    {
        $this->bookId = $bookId;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->status = $status;
    }

}
