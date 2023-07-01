<?php

include '../Abstract/interface.php';
include '../Database/database.php';

class Users extends Database implements user
{
  public function createTable()
  {
    
    $this->setup();

    $create = "CREATE TABLE IF NOT EXISTS users(
        id int primary key auto_increment,
        first_name varchar(255) not null,
        last_name varchar(255) not null,
        address varchar(255) not null,
        email varchar(50) not null
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
  $firstName = $params['first_name'] ?? '';
  
  $search = "SELECT * FROM users where first_name like '%$firstName%'";
 
  $user = $this->conn->query($search);
 
  if (empty($this->getError())) {
 
      return json_encode($user->fetch_all(MYSQLI_ASSOC));
    } else {
      return json_encode([
        'code' => 500,
        'message' => $this->getError(),
      ]);
     }
    }

    public function getAll()
 {
   $user = $this->conn->query("SELECT * FROM users");

   return json_encode($user->fetch_all(MYSQLI_ASSOC));
 }
 
 public function create($params)
{
  if ($_SERVER['REQUEST_METHOD'] != 'POST'){
    return json_encode( [
    
      'code' => 422,
      'message' => 'Post method is only allowed',
    ]);
  }
 
  if (!isset($params['first_name']) || empty($params['first_name'])){
 
   return json_encode( [
   'code' => 422,
   'message' => 'name of user is required',
 ]);
}

if (!isset($params['last_name']) || empty($params['last_name'])){

 return json_encode([
 'code' => 422,
 'message' => 'last_name is required',
]);
}
if (!isset($params['address']) || empty($params['address'])){

  return json_encode([
  'code' => 422,
  'message' => 'address is required',
 ]);
 }
 if (!isset($params['email']) || empty($params['email'])){

  return json_encode([
  'code' => 422,
  'message' => 'email is required',
 ]);
 }

 
$firstName = $params['first_name'];
$last_name = $params['last_name'];
$address = $params['address'];
$email = isset($params['email']) ? $params['email'] : '';

$insert = "INSERT INTO users(first_name, last_name, address, email) 
VALUES('$firstName', '$last_name', '$address', '$email')";

$isAdded = $this->conn->query($insert);

if($isAdded){
  return json_encode([
    'code' => 200,
    'message' => 'user Successfully Added',
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

  if (!isset($params['first_name']) || empty($params['first_name'])){
 
   return json_encode( [
   'code' => 422,
   'message' => 'name of user is required',
 ]);
 
  }
  if (!isset($params['last_name']) || empty($params['last_name'])){

    return json_encode([
    'code' => 422,
    'message' => 'last_name is required',
  ]);
}
if (!isset($params['address']) || empty($params['address'])){

  return json_encode([
  'code' => 422,
  'message' => 'address is required',
 ]);
}
if (!isset($params['email']) || empty($params['email'])){

  return json_encode([
  'code' => 422,
  'message' => 'email is required',
  ]);
}
if (!isset($params['id']) || empty($params['id'])){

 return json_encode([
 'code' => 422,
 'message' => 'id is required',
]);
}
$id = $params['id'];
$firstName = $params['first_name'];
$last_name = $params['last_name'];
$address = $params['address'];
$email = isset($params['email']) ? $params['email'] : '';

$update = "UPDATE users
       SET first_name = '$firstName', last_name = '$last_name', address = '$address', email = '$email'
       where id = '$id' ";

$isUpdated = $this->conn->query($update);

if($isUpdated){
  return json_encode([
    'code' => 200,
    'message' => 'user Successfully Updated',
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

$delete = "DELETE FROM users where id = '$id'";

$isDeleted = $this->conn->query($delete);

if($isDeleted){
 return json_encode([
   'code' => 200,
   'message' => 'user Successfully Deleted',
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
