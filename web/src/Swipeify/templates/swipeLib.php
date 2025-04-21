<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="author" content="Sungyun Jin" >
    <meta name="description" content="Swipe Playlist Page of Swipeify" >
    <meta name="keywords" content="swipeify, song swipe, spotify, swipe, sort Spotify songs, playlist manager">

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    >
    <link rel="stylesheet/less" type="text/css" href="./styles/swipeLib.less" />
    <style>
      body {
        background-color: #121212;
        color: white;
      }
      .heart-icon,
      .trashcan-icon {
        width: 60px;
        cursor: pointer;
        transition: transform 0.2s ease;
      }
      .heart-icon:hover,
      .trashcan-icon:hover {
        transform: scale(1.1);
      }
      .song-container img {
        max-width: 250px;
        border-radius: 12px;
      }
      .song-container {
        transition: transform 0.3s ease, opacity 0.3s ease;
      }
      .min-vh-100 {
        min-height: 100vh;
      }
    </style>

    <title>Swipeify - Swipe</title>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg" style="background-color: #343A3F;">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="?command=home">Swipeify</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
          style="filter: invert(1)"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link text-white" href="?command=home">Home</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="?command=welcome">About</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Services</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Contact</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="#">Account</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="d-flex justify-content-center mt-4">
      <button class="btn btn-success btn-lg">Library</button>
    </div>

    <div class="container d-flex justify-content-center align-items-center min-vh-100 text-center">
      <div class="d-flex justify-content-between align-items-center w-100" style="max-width: 600px;">
        
        <!-- Left (Keep) -->
        <div class="mx-3 text-center">
          <img src="./images/heart-icon.png" alt="Keep in Library" class="heart-icon" />
          <h5>Keep</h5>
        </div>

        <!-- Center (Song Display) -->
        <div class="song-container mx-3 text-center">
          <img id="main-img" src="./images/album1.png" alt="Picture of album" class="mb-3" />
          <h2 id="song-title">Loading...</h2>
          <h4 id="song-artist"></h4>
        </div>

        <!-- Right (Delete) -->
        <div class="mx-3 text-center">
          <img class="trashcan-icon" src="./images/trash-can.svg" alt="Delete" />
          <h5>Delete</h5>
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <script>
      const songs = [
        {
          title: "Blinding Lights",
          artist: "The Weeknd",
          album_art_url: "https://upload.wikimedia.org/wikipedia/en/0/09/The_Weeknd_-_Blinding_Lights.png"
        },
        {
          title: "Levitating",
          artist: "Dua Lipa",
          album_art_url: "https://upload.wikimedia.org/wikipedia/en/6/6e/Dua_Lipa_-_Levitating.png"
        },
        {
          title: "As It Was",
          artist: "Harry Styles",
          album_art_url: "https://upload.wikimedia.org/wikipedia/en/9/99/Harry_Styles_-_As_It_Was.png"
        }
      ];
    
      const likedSongs = [];
      let songIndex = 0;
    
      function displaySong(index) {
        if (index >= songs.length) {
          document.querySelector(".song-container").innerHTML = "<h2>No more songs!</h2>";
          console.log("Liked Songs:", likedSongs);
          return;
        }
    
        const song = songs[index];
        document.getElementById("main-img").src = song.album_art_url;
        document.getElementById("song-title").textContent = song.title;
        document.getElementById("song-artist").textContent = song.artist;
      }
    
      function swipeLeft() {
        likedSongs.push(songs[songIndex]);
        console.log("KEEP (left):", songs[songIndex]);
        songIndex++;
        displaySong(songIndex);
      }
    
      function swipeRight() {
        console.log("DELETE (right):", songs[songIndex]);
        songIndex++;
        displaySong(songIndex);
      }
    
      function registerSwipeGesture() {
        let touchStartX = 0;
        let touchEndX = 0;
    
        const gestureZone = document.querySelector(".song-container");
    
        gestureZone.addEventListener("touchstart", (e) => {
          touchStartX = e.changedTouches[0].screenX;
        });
    
        gestureZone.addEventListener("touchend", (e) => {
          touchEndX = e.changedTouches[0].screenX;
          const delta = touchEndX - touchStartX;
          if (Math.abs(delta) < 30) return;
          delta < 0 ? swipeLeft() : swipeRight();
        });
      }
    
      document.addEventListener("DOMContentLoaded", () => {
        document.querySelector(".heart-icon").addEventListener("click", swipeLeft);
        document.querySelector(".trashcan-icon").addEventListener("click", swipeRight);
        registerSwipeGesture();
        displaySong(songIndex);
      });
    </script>
    
  </body>
</html>
