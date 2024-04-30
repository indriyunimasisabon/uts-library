<?php
require_once 'features/library.php';

$library = new Library();

$dataBook = [
  [1, "The Great Gatsby", "F. Scott Fitzgerald", 1925, 1, "978-0-7432-7356-5", "Scribner"],
  [2, "To Kill a Mockingbird", "Harper Lee", 1960, 1, "978-0-06-112008-4", "J. B. Lippincott & Co."],
  [3, "1984", "George Orwell", 1949, 1, "978-0-452-28423-4", "Secker & Warburg"],
  [4, "Pride and Prejudice", "Jane Austen", 1813, 1, "978-0-14-143951-8", "T. Egerton, Whitehall"],
  [5, "The Catcher in the Rye", "J.D. Salinger", 1951, 1, "978-0-316-76948-0", "Little, Brown and Company"],
  [6, "The Hobbit", "J.R.R. Tolkien", 1937, 1, "978-0-395-07122-3", "Allen & Unwin"],
  [7, "The Lord of the Rings", "J.R.R. Tolkien", 1954, 1, "978-0-618-34625-6", "Allen & Unwin"],
  [8, "The Chronicles of Narnia", "C.S. Lewis", 1950, 1, "978-0-06-623850-0", "Geoffrey Bles"],
  [9, "Harry Potter and the Philosopher's Stone", "J.K. Rowling", 1997, 1, "978-0-7475-3269-6", "Bloomsbury"],
  [10, "Harry Potter and the Chamber of Secrets", "J.K. Rowling", 1998, 1, "978-0-7475-3849-0", "Bloomsbury"],
  [11, "Harry Potter and the Prisoner of Azkaban", "J.K. Rowling", 1999, 1, "978-0-7475-4215-2", "Bloomsbury"],
  [12, "Harry Potter and the Goblet of Fire", "J.K. Rowling", 2000, 1, "978-0-7475-4624-1", "Bloomsbury"],
  [13, "Harry Potter and the Order of the Phoenix", "J.K. Rowling", 2003, 1, "978-0-7475-5100-7", "Bloomsbury"],
  [14, "Harry Potter and the Half-Blood Prince", "J.K. Rowling", 2005, 1, "978-0-7475-8108-1", "Bloomsbury"],
  [15, "Harry Potter and the Deathly Hallows", "J.K. Rowling", 2007, 1, "978-0-545-01022-1", "Arthur A. Levine Books"],
  [16, "The Da Vinci Code", "Dan Brown", 2003, 1, "978-0-385-50420-5", "Doubleday"],
  [17, "Angels & Demons", "Dan Brown", 2000, 1, "978-0-671-02735-7", "Pocket Books"],
  [18, "The Girl with the Dragon Tattoo", "Stieg Larsson", 2005, 1, "978-0-307-26926-0", "Norstedts Förlag"],
  [19, "The Hunger Games", "Suzanne Collins", 2008, 1, "978-0-439-02348-1", "Scholastic"],
  [20, "The Girl on the Train", "Paula Hawkins", 2015, 1, "978-1-59-463402-4", "Riverhead Books"],
];

foreach ($dataBook as $book) {
  $library->addBook(new ReferenceBook($book[0], $book[1], $book[2], $book[3], $book[4], $book[5], $book[6]));
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Lakukan pencarian jika keyword tidak kosong
if (!empty($keyword)) {
  $searchResult = $library->searchBook($keyword);
} else {
  // Jika keyword kosong, tampilkan semua data buku
  $searchResult = $library->books;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['borrow'])) {
      $bookId = $_POST['book_id'];
      $message = $library->borrowBook($bookId);
      echo "<script>alert('$message');</script>";
  } elseif (isset($_POST['return'])) {
      $bookId = $_POST['book_id'];
      $lateFee = $library->returnBook($bookId, 0); // Anda dapat mengganti ID pengguna dengan ID yang sesuai
      if (is_numeric($lateFee)) {
          echo "<script>alert('Buku berhasil dikembalikan. Denda keterlambatan: $' + $lateFee);</script>";
      } else {
          echo "<script>alert('$lateFee');</script>";
      }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
  <title>Library App | Indri Yuni</title>
</head>

<body>
  <div class="container-fluid hero text-center">
    <div class="row align-items-center mt-5">
      <div class="col p-4">
        <h1>Library App</h1>
        <form action="" method="GET" class="row justify-content-center py-4">
          <div class="col-4">
            <label for="search" class="visually-hidden">Search title or author</label>
            <input name="keyword" type="text" class="form-control" id="Search" placeholder="Search title or author">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-success">Search</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Author</th>
          <th scope="col">Year</th>
          <th scope="col">ISBN</th>
          <th scope="col">Publisher</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($searchResult as $book) { ?>
          <tr>
            <th scope="row"><?= $book->bookId ?></th>
            <td><?= $book->title ?></td>
            <td><?= $book->author ?></td>
            <td><?= $book->year ?></td>
            <td><?= $book->isbn ?></td>
            <td><?= $book->publisher ?></td>
            <td><?= $book->status ? "Tersedia" : "Dipinjam" ?></td>
            <td>
              <?php if ($book->status == 1) : ?>
                <form action="" method="POST">
                  <input type="hidden" name="book_id" value="<?= $book->bookId ?>">
                  <button type="submit" name="borrow" class="btn btn-primary">Pinjam</button>
                </form>
              <?php else : ?>
                <form action="" method="POST">
                  <input type="hidden" name="book_id" value="<?= $book->bookId ?>">
                  <button type="submit" name="return" class="btn btn-warning">Kembalikan</button>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>