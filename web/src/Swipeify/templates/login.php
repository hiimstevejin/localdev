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
        <div class="mb-3">
          <a href="https://accounts.spotify.com/authorize?client_id=YOUR_CLIENT_ID&response_type=code&redirect_uri=YOUR_REDIRECT_URI&scope=user-read-private%20user-read-email
          " class="btn btn-success">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Spotify_icon.svg" alt="Spotify Logo" width="20" class="me-2">
            Log in with Spotify
          </a>
        </div>

        <div class="mb-3">
          <label for="fullname" class="form-label">Name</label>
          <input type="text" class="form-control" id="fullname" name="fullname">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="check">
          <label class="form-check-label" for="check">Show Password</label>
        </div>
        <div>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
    <script>
          document.getElementById("check").addEventListener("change", function() {
        var passwordField = document.getElementById("password");
        if (this.checked) {
          passwordField.type = "text"; // Show password
        } else {
          passwordField.type = "password"; // Hide password
        }
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less" ></script>
  </body>
</html>