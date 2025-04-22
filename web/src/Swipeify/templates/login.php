<?php
include_once __DIR__ . '/../Config.php';
$client_id = Config::$spotify["clientid"];
$redirect_uri = 'http://127.0.0.1:8080/index.php?command=callback';
$scope = 'user-read-private user-read-email user-library-read';

$authorize_url = 'https://accounts.spotify.com/authorize?'.http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'scope' => $scope,
    'redirect_uri' => $redirect_uri
]);
?>

<!-- sj3sj -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="author" content="Sungyun Jin" >
    <meta name="description" content="Login Page of Swipeify" >
    <meta
      name="keywords"
      content="swipeify, song swipe, spotify, swipe, sort Spotify songs, playlist manager"
    >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet/less" type="text/css" href="./styles/login.less" >
    <title>Swipeify - Login</title>

  </head>
  <body>
  <?=$message?>
    <div class="container">
      <form action="?command=login" method="post">
      <h1>Swipeify</h1>
        <div class="mb-3">
        <a href="<?php echo $authorize_url; ?>" class="btn btn-success">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Spotify_icon.svg" alt="Spotify Logo" width="20" class="me-2">
            Log in with Spotify
          </a>
        </div>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less" ></script>
  </body>
</html>