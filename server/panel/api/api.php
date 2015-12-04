<?php
include('../bootstrap.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
// Register
if(@$_POST["Action"]=="Register"){
  $username = $_POST["username"];
  $users = collection("users")->find(["username"=>$username])->toArray();
  if(sizeof($users)==0){
    $user = $_POST;
    // If api request is valid
    if($_POST["password"] && $_POST["email"]){
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
if(@$_POST["Action"]=="Login"){
  $username = $_POST["username"];
  $password = $_POST["password"];
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
// Get All Needs
if(@$_POST["Action"]=="GetNeeds"){
  $items = collection("needs")->find()->toArray();
  for($i=0;$i<sizeof($items);$i++){
    $item = $items[$i];
    $organization = collection("organizations")->find(["_id"=>$item["organization"]])->toArray();

    $items[$i]["organization"] = $organization[0];
  }
  echo json_encode($items);
}
// Get A Collection
if(@$_POST["collection"] && @$_POST["collection"] != "users"){
  if($_POST["limit"] && $_POST["skip"]){
    $items = collection($_POST["collection"])->find()->limit($_POST["limit"])->skip($_POST["skip"])->toArray();
  }
  else{
    $items = collection($_POST["collection"])->find()->toArray();
  }
  echo json_encode($items);
}

// Get organization needs
if($_POST["organizationNeeds"]){
  if(@$_POST["_id"]){
    $needs = cockpit('collections:find', 'needs', ['organization'=>$_POST["_id"]]);
    echo json_encode($needs);
  }
  else{
    echo '
      {"status":false,"message":"Provide organization _id!"}
    ';
  }
}
// Get Organization
if($_POST["organization"]){
  if(@$_POST["_id"]){
    $organization = cockpit('collections:findOne', 'organizations', ['_id'=>$_POST["_id"]]);
    echo json_encode($organization);
  }
  else{
    echo '
      {"status":false,"message":"Provide organization _id!"}
    ';
  }
}

// Donate
if($_POST["Action"]=="Donate"){
  if(@$_POST["need_id"]){
    $need = cockpit('collections:findOne', 'needs', ['_id'=>$_POST["need_id"]]);
    $Donation = [
      "donator" => $_POST["donator_id"],
      "need" => $_POST["need_id"],
      "message" => $_POST["message"]
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
