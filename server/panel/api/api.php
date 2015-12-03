<?php
include('../bootstrap.php');

// Register
if(@$_GET["register"]){
  $username = $_GET["username"];
  $users = collection("users")->find(["username"=>$username])->toArray();
  if(sizeof($users)==0){
    $user = $_GET;
    // If api request is valid
    if($_GET["password"] && $_GET["email"]){
      cockpit('collections:save_entry', 'users', $user);
      echo '
        {"status":true,"message":"Successfully registered your user"}
      ';
    }
    else{
      echo '
        {"status":false,"message":"You should provide a password and an email address!"}
      ';
    }

  }
  else{
    echo '
      {"status":false,"message":"A user with this username already exists! "}
    ';
  }
}

// Login
if(@$_GET["login"]){
  $username = $_GET["username"];
  $password = $_GET["password"];
  $users = collection("users")->find(["username"=>$username,"password"=>$password])->toArray();

  if(sizeof($users)!=0){
    echo '
      {"status":true,"message":"Successfully logged in!","info":'.json_encode($users[0]).'}
    ';
  }
  else{
    echo '
      {"status":false,"message":"Login failed! Check your username and password!"}
    ';
  }
}

// Get A Collection
if(@$_GET["collection"] && @$_GET["collection"] != "users"){
  if($_GET["limit"] && $_GET["skip"]){
    $items = collection($_GET["collection"])->find()->limit($_GET["limit"])->skip($_GET["skip"])->toArray();
  }
  else{
    $items = collection($_GET["collection"])->find()->toArray();
  }
  echo json_encode($items);
}

// Get organization needs
if($_GET["organizationNeeds"]){
  if(@$_GET["_id"]){
    $needs = cockpit('collections:find', 'needs', ['organization'=>$_GET["_id"]]);
    echo json_encode($needs);
  }
  else{
    echo '
      {"status":false,"message":"Provide organization _id!"}
    ';
  }
}
// Get Organization
if($_GET["organization"]){
  if(@$_GET["_id"]){
    $organization = cockpit('collections:findOne', 'organizations', ['_id'=>$_GET["_id"]]);
    echo json_encode($organization);
  }
  else{
    echo '
      {"status":false,"message":"Provide organization _id!"}
    ';
  }
}

// Donate
if($_GET["donate"]){
  if(@$_GET["need_id"]){
    $need = cockpit('collections:findOne', 'needs', ['_id'=>$_GET["need_id"]]);
    $Donation = [
      "donator" => $_GET["donator_id"],
      "need" => $_GET["need_id"],
      "message" => $_GET["message"]
    ];
    
    cockpit('collections:save_entry', 'donations', $Donation);
    echo '
      {"status":true,"message":"Thank you for your donation!"}
    ';
  }
  else{
    echo '
      {"status":false,"message":"Provide donator_id and need_id!"}
    ';
  }
}
?>
