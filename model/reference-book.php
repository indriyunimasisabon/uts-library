<?php

require_once 'book.php';
class ReferenceBook extends Book
{
    public $isbn;
    public $publisher;

    function __construct($id, $title, $author, $year, $status, $isbn, $publisher)
    {
        parent::__construct($id, $title, $author, $year, $status);
        $this->isbn = $isbn;
        $this->publisher = $publisher;
    }
}
