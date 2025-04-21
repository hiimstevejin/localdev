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

    <div class="container d-flex justify-content-center align-items-center py-5 text-center">
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
    
    <div class="container mt-5">
      <h3>Liked Songs</h3>
      <ul id="liked-songs-list" class="list-group text-start bg-dark"></ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <script>
      const songs = [
        {
          title: "Blinding Lights",
          artist: "The Weeknd",
          album_art_url: "https://picsum.photos/300?random=1"
        },
        {
          title: "Levitating",
          artist: "Dua Lipa",
          album_art_url: "https://picsum.photos/300?random=2"
        },
        {
          title: "As It Was",
          artist: "Harry Styles",
          album_art_url: "https://picsum.photos/300?random=3"
        },
        {
          title: "1989 (Taylor’s Version)",
          artist: "Taylor Swift",
          album_art_url: "https://picsum.photos/300?random=4"
        },
        {
          title: "Random Access Memories",
          artist: "Daft Punk",
          album_art_url: "https://picsum.photos/300?random=5"
        },
        {
          title: "Divide",
          artist: "Ed Sheeran",
          album_art_url: "https://picsum.photos/300?random=6"
        },
        {
          title: "Future Nostalgia",
          artist: "Dua Lipa",
          album_art_url: "https://picsum.photos/300?random=7"
        },
        {
          title: "After Hours",
          artist: "The Weeknd",
          album_art_url: "https://picsum.photos/300?random=8"
        },
        {
          title: "Fine Line",
          artist: "Harry Styles",
          album_art_url: "https://picsum.photos/300?random=9"
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
        renderLikedSongs();
        songIndex++;
        displaySong(songIndex);
      }
    
      function swipeRight() {
        console.log("DELETE (right):", songs[songIndex]);
        songIndex++;
        displaySong(songIndex);
      }
    
      function renderLikedSongs() {
        const list = document.getElementById("liked-songs-list");
        list.innerHTML = ""; // Clear existing list

        likedSongs.forEach((song, index) => {
          const item = document.createElement("li");
          item.className = "list-group-item bg-secondary text-white d-flex justify-content-between align-items-center";
          item.innerHTML = `
            <span>${index + 1}. ${song.title} - ${song.artist}</span>`;
          list.appendChild(item);
        });
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
