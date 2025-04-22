<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="author" content="Jack Nickerson" >
    <meta name="description" content="Home Page for Swipeify" >
    <meta
      name="keywords"
      content="swipeify, song swipe, spotify, swipe, sort Spotify songs, playlist manager"
    >

    <title>Swipeify</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous">

    <link rel="stylesheet/less" type="text/css" href="./styles/custom.less">
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
  </head>

  <body style="min-height: 100vh; display: flex; flex-direction: column;">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-2" href="index.php?command=home">Swipeify</a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarTogglerDemo"
          aria-controls="navbarTogglerDemo"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item"><a class="nav-link" href="index.php?command=home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?command=welcome">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?command=logout">Log Out</a></li>
            <li class="nav-item"><a class="btn btn-light" href="index.php?command=sync">Sync Library<img class="img-responsive center-block" src="images/refresh.png" alt="Refresh Icon" style="margin-left: 10px; height: 25px;"></a></li>
          </ul>
        </div>
      </nav>
    </header>

    <main style="flex: 1;">
      <section class="row" style="display: block; text-align: center;">
      <h2 style="margin: 40px;"><?php echo "Welcome, " . htmlspecialchars($_SESSION["name"]) . "!"; ?></h2>
        <h1 style="margin: 40px;">Swipe Through Your Favorite Songs</h1>
        <a class="btn btn-success" href="index.php?command=swipelibrary" style="border-radius: 20px;">
          <p class="btn-top-p" style="font-size: 40px; font-weight: 800; margin-bottom: 0px;">Library</p>
          <p class="btn-bottom-p" style="font-size: 12px; margin-bottom: 5px;">Swipe from your library</p>
        </a><br>
        <a class="btn btn-warning" href="index.php?command=search" style="border-radius: 20px; margin-top: 20px;">
          <p class="btn-top-p" style="font-size: 40px; font-weight: 800; margin-bottom: 0px;">Playlist/Album</p>
          <p class="btn-bottom-p" style="font-size: 12px; margin-bottom: 5px;">Swipe from other's playlists/albums</p>
        </a>
      </section>

      <section>
        <h2>Your Saved Songs</h>
          <table class="table table-bordered table-dark">
            <thead>
              <tr>
                <th>Song</th>
                <th>Artist</th>
                <th>Album</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($songs as $song): ?>
                <tr>
                  <td><?php echo htmlspecialchars($song['song_name']); ?></td>
                  <td><?php
                        $artistNames = $song["artist_names"] ?? [];
                        if (is_array($artistNames)) {
                          echo htmlspecialchars(implode(", ", $artistNames));
                        } else {
                          echo $artistNames;
                        }
                        ?></td>
                  <td><?php echo htmlspecialchars($song['album_name']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      </section>

      <!--
      <section>
        <h2>Continue Swiping</h2>
        <div class="d-flex flex-row flex-nowrap overflow-auto" style="overflow-x: scroll;">
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
                <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
                <div class="card-body">
                  <h5 class="card-title text-dark">Session_Name</h5>
                  <p class="card-text" style="font-size: 14px;">Session Description</p>
                  <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
                </div>
            </div>
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Session_Name</h5>
                <p class="card-text" style="font-size: 14px;">Session Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
          </div>
        </div>
      </section>

      <section>
        <h2>Previously Swiped</h2>
        <div class="d-flex flex-row flex-nowrap overflow-auto" style="overflow-x: scroll;">
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Playlist_Name</h5>
                <p class="card-text" style="font-size: 14px;">Playlist Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
            </div>
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Playlist_Name</h5>
                <p class="card-text" style="font-size: 14px;">Playlist Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
            </div>
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Playlist_Name</h5>
                <p class="card-text" style="font-size: 14px;">Playlist Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
            </div>
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Playlist_Name</h5>
                <p class="card-text" style="font-size: 14px;">Playlist Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
            </div>
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Playlist_Name</h5>
                <p class="card-text" style="font-size: 14px;">Playlist Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
            </div>
            <div class="card card-block mx-2 mb-3" style="max-width: 300px; min-width: 300px;">
              <img src="./images/temporary.jpg" class="card-img-top" alt="temporary">
              <div class="card-body">
                <h5 class="card-title text-dark">Playlist_Name</h5>
                <p class="card-text" style="font-size: 14px;">Playlist Description</p>
                <a href="#" class="btn btn-primary" style="font-size: 14px;">Continue Session</a>
              </div>
            </div>
        </div>
      </section>
      -->
    </main>

    <footer class="bg-dark text-white text-center py-3">
      <p>&copy; 2025 SJ3SJ. All rights reserved.</p>
    </footer>

    <script
      src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
