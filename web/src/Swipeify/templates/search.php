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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="author" content="Jack Nickerson" >
    <meta name="description" content="Search for swipeify" >
    <meta
      name="keywords"
      content="swipeify, song swipe, spotify, swipe, sort Spotify songs, playlist manager"
    >

    <title>Swipeify - Search</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous">

    <link rel="stylesheet/less" type="text/css" href="./styles/custom.less">
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      const spotifyAccessToken = "<?= $_SESSION['spotify_access_token'] ?>";
    </script>
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
            <li class="nav-item"><a class="nav-link" href="#">Account</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <main style="flex: 1;">
      <section class="title row">
        <h1 style="margin-left: auto; margin-right: auto;">Search for Album/Playlist</h1>
      </section>

      <form id="searchForm" class="form-inline my-2 my-lg-0">
        <div style="margin-left: auto; margin-right: auto;">
          <input id="searchQuery" class="form-control mr-sm-2" type="search" name="query" placeholder="Search" aria-label="Search" style="width: 400px;">
          <button type="submit" class="btn" style="background-color: white;">
            <img class="img-responsive center-block" src="images/search.png" alt="Magnifying Glass" style="height: 20px;">
          </button>
        </div>
      </form>

    <div id="results" style="padding: 20px;"></div>

    </main>
    <footer class="bg-dark text-white text-center py-3">
      <p>&copy; 2025 SJ3SJ. All rights reserved.</p>
    </footer>

    <script>
      document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const query = document.getElementById('searchQuery').value;
        const resultsDiv = document.getElementById('results');

        if (!query) return;

        fetch(`https://api.spotify.com/v1/search?q=${encodeURIComponent(query)}&type=album&limit=10`, {
          headers: {
            'Authorization': 'Bearer ' + spotifyAccessToken
          }
        })
        .then(response => response.json())
        .then(data => {
          resultsDiv.innerHTML = '';

          if (data.albums && data.albums.items.length > 0) {
            resultsDiv.innerHTML += '<h3>Albums</h3>';
            data.albums.items.forEach(album => {
              resultsDiv.innerHTML += `
                <div class="result-item" style="margin: 10px 0; padding: 10px; border-radius: 5px;">
                  <img src="${album.images[0]?.url}" alt="${album.name}" style="height: 50px;">
                  <strong>${album.name}</strong> by ${album.artists.map(a => a.name).join(', ')}
                </div>`;
            });
          }

          if (!data.albums.items.length) {
            resultsDiv.innerHTML = '<p>No results found.</p>';
          }
        })
        .catch(err => {
          console.error(err);
          resultsDiv.innerHTML = '<p>Error fetching results.</p>';
        });
      });
      </script>
      <script>
        $(document).on('mouseenter', '.result-item', function() {
          $(this).css('background-color', '#f0f0f0');
        }).on('mouseleave', '.result-item', function() {
          $(this).css('background-color', '');
        });
      </script>


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
