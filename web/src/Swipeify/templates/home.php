<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <meta name="author" content="Jack Nickerson" >
    <meta name="description" content="Home Page for Swipeify" >

    <title>Swipeify</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
      crossorigin="anonymous">

    <link rel="stylesheet/less" type="text/css" href="./styles/custom.less">
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
  </head>

  <body style="min-height: 100vh; display: flex; flex-direction: column;">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-2" href="index.php?command=home">Swipeify</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item"><a class="nav-link" href="index.php?command=home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?command=logout">Log Out</a></li>
            <li class="nav-item"><a class="btn btn-light" href="index.php?command=sync">Sync Library<img class="img-responsive center-block" src="images/refresh.png" alt="Refresh Icon" style="margin-left: 10px; height: 25px;"></a></li>
          </ul>
        </div>
      </nav>
    </header>

    <main style="flex: 1;">
      <section class="row" style="display: block; text-align: center;">
        <h2 style="margin: 40px;">Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>
        <h1 style="margin: 40px;">Swipe Through Your Favorite Songs</h1>
        <a class="btn btn-success" href="index.php?command=swipelibrary" style="border-radius: 20px;">
          <p class="btn-top-p" style="font-size: 40px; font-weight: 800; margin-bottom: 0px;">Library</p>
          <p class="btn-bottom-p" style="font-size: 12px; margin-bottom: 5px;">Swipe from your library</p>
        </a><br>
        <a class="btn btn-warning" href="index.php?command=search" style="border-radius: 20px; margin-top: 20px;">
          <p class="btn-top-p" style="font-size: 40px; font-weight: 800; margin-bottom: 0px;">Albums</p>
          <p class="btn-bottom-p" style="font-size: 12px; margin-bottom: 5px;">Search for Albums</p>
        </a>
      </section>

      <div class="container mb-3 d-flex justify-content-end">
        <label for="sort-select" class="mr-2 mt-1">Sort by:</label>
        <select id="sort-select" class="form-control w-auto">
          <option value="title">Song (A–Z)</option>
          <option value="artist">Artist (A–Z)</option>
          <option value="album">Album (A–Z)</option>
        </select>
      </div>

      <!-- 🎵 Songs Table -->
      <section class="container mb-5">
        <h2 class="mb-3">Your Saved Songs</h2>
        <table class="table table-bordered table-dark">
          <thead>
            <tr>
              <th>Song</th>
              <th>Artist</th>
              <th>Album</th>
            </tr>
          </thead>
          <tbody id="songs-table-body">
            <?php foreach ($songs as $song): ?>
              <tr>
                <td><?= htmlspecialchars($song['song_name']) ?></td>
                <td><?= htmlspecialchars(is_array($song["artist_names"]) ? implode(", ", $song["artist_names"]) : $song["artist_names"]) ?></td>
                <td><?= htmlspecialchars($song['album_name']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
      <p>&copy; 2025 SJ3SJ. All rights reserved.</p>
    </footer>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const tableBody = document.getElementById("songs-table-body");
        const sortSelect = document.getElementById("sort-select");

        sortSelect.addEventListener("change", () => {
          const rows = Array.from(tableBody.querySelectorAll("tr"));
          const columnIndex = {
            title: 0,
            artist: 1,
            album: 2
          }[sortSelect.value];

          rows.sort((a, b) => {
            const textA = a.children[columnIndex].textContent.trim().toLowerCase();
            const textB = b.children[columnIndex].textContent.trim().toLowerCase();
            return textA.localeCompare(textB);
          });

          tableBody.innerHTML = "";
          rows.forEach(row => tableBody.appendChild(row));
        });
      });
    </script>
  </body>
</html>
