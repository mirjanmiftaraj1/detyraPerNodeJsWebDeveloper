<?php
  // for example your user
  $user = $_GET['user'];
  $token = $_GET['token'];

  // We generate the url for curl
  $curl_url = 'https://api.github.com/users/' . $user . '/repos';

  // We generate the header part for the token
  $curl_token_auth = 'Authorization: token ' . $token;

  // We make the actuall curl initialization
  $ch = curl_init($curl_url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  // We set the right headers: any user agent type, and then the custom token header part that we generated
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));

  // We execute the curl
  $output = curl_exec($ch);

  // And we make sure we close the curl       
  curl_close($ch);

  // Then we decode the output and we could do whatever we want with it
  $output = json_decode($output, true);
  if (empty($output)) {
    $message = "user not exist";
    echo json_encode($message);
      die();
 }
 
  if(isset($output['message'])) {
    if($output['message'] == 'Not Found') {
      echo json_encode($output['message']);
      die();
    }

    if($output['message'] == 'Bad credentials') {
      echo json_encode($output['message']);
      die();
    }
  }

  if (!empty($output)) {
    $arr = [];
    foreach ($output as $repo) {
      array_push($arr,$repo['html_url']);
    }
    $object = json_encode($arr);
    print_r($object);
  }

?>