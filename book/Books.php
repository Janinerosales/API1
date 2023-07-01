<?php

include '../Abstract/interface.php';
include '../Database/database.php';

class Books extends Database implements user
{
  public function createTable()
  {
    
    $this->setup();

    $create = "CREATE TABLE IF NOT EXISTS books(
        id int primary key auto_increment,
        book_name varchar(255) not null,
        author varchar(255) not null,
        description varchar(255) not null,
        genre varchar(255) not null
        )";

    $this->conn->query($create);
  }
  
  public function getid($getid)
{
  if (!isset($getid['id']) || empty($getid['id']))
  {
    $response = [

        'code' => 422,
        'message' => 'id is required'

    ];
  
    return json_encode($response);
    
  }
 
  $id = $getid['id'];

  $data = $this->conn->query("SELECT * FROM $this->create WHERE id ='$id'");
  if($data->num_rows == 0)
  {
    $response = [

        'code' => 422,
        'message' => 'index not found',

    ];
    return json_encode($response);
  }
  return json_encode($data->fetch_assoc());
}

  public function search($params)
  {

  if ($_SERVER['REQUEST_METHOD'] != 'GET'){
    return json_encode( [
    
      'code' => 422,
      'message' => 'GET method is only allowed',
    ]);
  }
  $bookName = $params['book_name'] ?? '';
  
  $search = "SELECT * FROM users where book_name like '%$bookName%'";
 
  $book = $this->conn->query($search);
 
  if (empty($this->getError())) {
 
      return json_encode($book->fetch_all(MYSQLI_ASSOC));
    } else {
      return json_encode([
        'code' => 500,
        'message' => $this->getError(),
      ]);
     }
    }

    public function getAll()
 {
   $book = $this->conn->query("SELECT * FROM books");
   return json_encode($book->fetch_all(MYSQLI_ASSOC));
 }
 
 public function create($params)
{
  if ($_SERVER['REQUEST_METHOD'] != 'POST'){
    return json_encode( [
    
      'code' => 422,
      'message' => 'Post method is only allowed',
    ]);
  }
 
  if (!isset($params['book_name']) || empty($params['book_name'])){
 
   return json_encode( [
   'code' => 422,
   'message' => 'name of book is required',
 ]);
}

if (!isset($params['author']) || empty($params['author'])){

 return json_encode([
 'code' => 422,
 'message' => 'author is required',
]);
}
if (!isset($params['description']) || empty($params['description'])){

  return json_encode([
  'code' => 422,
  'message' => 'description is required',
 ]);
 }
 if (!isset($params['genre']) || empty($params['genre'])){

  return json_encode([
  'code' => 422,
  'message' => 'genre is required',
 ]);
 }

 
$bookName = $params['book_name'];
$author = $params['author'];
$description = $params['description'];
$genre = isset($params['genre']) ? $params['genre'] : '';

$insert = "INSERT INTO books(book_name, author, description, genre) 
VALUES('$bookName', '$author', '$description', '$genre')";

$isAdded = $this->conn->query($insert);

if($isAdded){
  return json_encode([
    'code' => 200,
    'message' => 'Book Successfully Added',
  ]);
 }
 else{
  return json_encode([
    'code' => 500,
    'message' => $this->getError(),
  ]);
 }
}

public function update($params)
{
  if ($_SERVER['REQUEST_METHOD'] != 'POST'){
    return json_encode( [
    
      'code' => 422,
      'message' => 'Post method is only allowed',
    ]);
  }

  if (!isset($params['book_name']) || empty($params['book_name'])){
 
   return json_encode( [
   'code' => 422,
   'message' => 'name of book is required',
 ]);
 
  }
  if (!isset($params['author']) || empty($params['author'])){

    return json_encode([
    'code' => 422,
    'message' => 'author is required',
  ]);
}
if (!isset($params['description']) || empty($params['description'])){

  return json_encode([
  'code' => 422,
  'message' => 'description is required',
 ]);
}
if (!isset($params['genre']) || empty($params['genre'])){

  return json_encode([
  'code' => 422,
  'message' => 'genre is required',
  ]);
}
if (!isset($params['id']) || empty($params['id'])){

 return json_encode([
 'code' => 422,
 'message' => 'id is required',
]);
}
$id = $params['id'];
$bookName = $params['book_name'];
$author = $params['author'];
$description = $params['description'];
$genre = isset($params['genre']) ? $params['genre'] : '';

$update = "UPDATE books
       SET book_name = '$bookName', author = '$author', description = '$description', genre = '$genre'
       where id = '$id' ";

$isUpdated = $this->conn->query($update);

if($isUpdated){
  return json_encode([
    'code' => 200,
    'message' => 'Book Successfully Updated',
  ]);
}
else{
 return json_encode([
   'code' => 500,
   'message' => $this->getError(),
 ]);
}
}
public function delete($params)
{
  if ($_SERVER['REQUEST_METHOD'] != 'GET'){
    return json_encode([
      'code' => 422,
      'message' => 'GET method is only allowed',
    ]);
 }


 if (!isset($params['id']) || empty($params['id'])){
  return json_encode([
  'code' => 422,
  'message' => 'id is required',
]);

}
$id = $params['id'];

$delete = "DELETE FROM books where id = '$id'";

$isDeleted = $this->conn->query($delete);

if($isDeleted){
 return json_encode([
   'code' => 200,
   'message' => 'Book Successfully Deleted',
 ]);
}
else{
 return json_encode([
   'code' => 500,
   'message' => $this->getError(),
 ]);
}

}

}
