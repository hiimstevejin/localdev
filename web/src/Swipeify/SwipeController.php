<?php

class SwipeController {

  private $db;

  private $errorMessage = "";

  /**
   * Constructor
   */
  public function __construct($input) {
    // Start the session!
    session_start();
    $this->db = new Database();
    $this->input = $input;
  }

  /**
   * Run the server
   * 
   * Given the input (usually $_GET), then it will determine
   * which command to execute based on the given "command"
   * parameter.  Default is the welcome page.
   */
  public function run() {
    // Get the command
    $command = "welcome";
    if (isset($this->input["command"]) && (
      $this->input["command"] == "login" || 
      $this->input["command"] == "showlogin" ||
      $this->input["command"] == "callback" ||
      isset($_SESSION["name"])))
      $command = $this->input["command"];

    switch($command) {
      case "showlogin":
        $this->showLogin();
        break;
      case "sync":
        $this->fetchSpotifySongs($_SESSION['spotify_access_token'], $_SESSION['curuserid']);
        break;
      case "callback":
        $this->callback();
        break;
      case "songsjson":
        echo $this -> getSongsJSON();
        break;
      case "home":
        $this->showHome();
        break;
      case "swipelibrary":
        $this->showSwipeLib();
        break;
      case "search":
        $this->showSearch();
        break;
      case "logout":
        $this->logout();
      case "welcome":
      default:
        $this->showWelcome();
        break;
    }
  }

  /**
   * Logout function.  We **need** to clear the session somehow.
   * When the user wants to start over, we should allow them to
   * reset the game.  I'll call it logout, so this function destroys
   * the session and immediately starts a new one.  (new!)
   */
  public function logout() {
    session_destroy();
    session_start();
  }

  public function showSongDetail() {
    $id = $_GET["id"] ?? null;
  
    if ($id && preg_match("/^[a-zA-Z0-9]+$/", $id)) {
      $result = $this->db->query("SELECT * FROM tracks WHERE spotify_id = $1", $id);
  
      if ($result) {
        $song = $result[0];
        include("/path/to/songdetail.php");
      } else {
        echo "Song not found.";
      }
    } else {
      echo "Invalid or missing song ID.";
    }
  }
  
  public function getSongs() {
    $result = $this->db->query("select id from swipeify_users where email = $1 LIMIT 1;", $_SESSION["email"]);
    if ($result) {
      $_SESSION["curuserid"] = $result[0]["id"];
    }
    $results = $this->db->query("SELECT
      tracks.name AS song_name,
      albums.name AS album_name,
      albums.image_url AS image_url,
      array_agg(DISTINCT artists.name) AS artist_names
    FROM user_tracks
    JOIN tracks ON user_tracks.track_id = tracks.spotify_id
    JOIN album_tracks ON tracks.spotify_id = album_tracks.track_id
    JOIN albums ON album_tracks.album_id = albums.spotify_id
    JOIN artist_albums ON albums.spotify_id = artist_albums.album_id
    JOIN artists ON artist_albums.artist_id = artists.spotify_id
    WHERE user_tracks.user_id = $1
    GROUP BY tracks.spotify_id, tracks.name, albums.name, albums.spotify_id", $_SESSION["curuserid"]);
    foreach ($results as &$row) {
      if (isset($row["artist_names"]) && is_string($row["artist_names"])) {
        $row["artist_names"] = str_getcsv(trim($row["artist_names"], '{}'));
      }
    }
    return $results;
  }

  public function getSongsJSON() {
    header('Content-Type: application/json');
    $results = $this->db->query("
      SELECT
        tracks.spotify_id AS song_id,
        tracks.name AS song_name,
        albums.name AS album_name,
        albums.image_url AS album_art_url,
        array_agg(DISTINCT artists.name) AS artist_names
      FROM user_tracks
      JOIN tracks ON user_tracks.track_id = tracks.spotify_id
      JOIN album_tracks ON tracks.spotify_id = album_tracks.track_id
      JOIN albums ON album_tracks.album_id = albums.spotify_id
      JOIN artist_albums ON albums.spotify_id = artist_albums.album_id
      JOIN artists ON artist_albums.artist_id = artists.spotify_id
      WHERE user_tracks.user_id = $1
      GROUP BY tracks.spotify_id, tracks.name, albums.name, albums.image_url
    ", $_SESSION['curuserid']);
    $songs = [];
    foreach ($results as $row) {
      $artists = is_string($row["artist_names"]) ? str_getcsv(trim($row["artist_names"], '{}')) : (is_array($row["artist_names"]) ? $row["artist_names"] : []);
      $songs[] = [
        "title" => $row["song_name"],
        "artist" => implode(", ", $artists),
        "album_art_url" => $row["album_art_url"],
        "user_id" => $_SESSION['curuserid'],
        "song_id" => $row["song_id"]
      ];
    }
    return json_encode($songs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  }  

  public function getSearch($message = "") {
    include("/opt/src/Swipeify/templates/swipeLib.html");
    // include("/students/rze7ud/students/rze7ud/private/Swipeify/templates/search.html");
  }

  public function showSwipeLib($message = "") {
    include("/opt/src/Swipeify/templates/swipeLib.php");
    // include("/students/rze7ud/students/rze7ud/private/Swipeify/templates/swipeLib.html");
  }
  public function showSearch($message = "") {
    include("/opt/src/Swipeify/templates/search.php");
    // include("/students/rze7ud/students/rze7ud/private/Swipeify/templates/search.php");
  }

  public function showHome($message = "") {
    $songs = $this->getSongs();
    include("/opt/src/Swipeify/templates/home.php");
    // include("/students/rze7ud/students/rze7ud/private/Swipeify/templates/home.php");
    // echo json_encode($songs);
  }

  public function showLogin($message = "") {
    include("/opt/src/Swipeify/templates/login.php");
    // include("/students/rze7ud/students/rze7ud/private/Swipeify/templates/login.php");
  }
  
  public function showWelcome($message = "") {
    include("/opt/src/Swipeify/templates/index.html");
    // include("/students/rze7ud/students/rze7ud/private/Swipeify/templates/index.html");
  }

  public function callback($message = "") {
    if (!isset($this->input['code'])) {
      echo "Authorization code not found.";
      return;
    }
  
    $code = $this->input['code'];
  
    $client_id = Config::$spotify["clientid"];
    $client_secret = Config::$spotify["clientsecret"];
    $redirect_uri = 'http://127.0.0.1:8080/index.php?command=callback';
  
    $token_url = 'https://accounts.spotify.com/api/token';
  
    $post_fields = [
      'grant_type' => 'authorization_code',
      'code' => $code,
      'redirect_uri' => $redirect_uri,
      'client_id' => $client_id,
      'client_secret' => $client_secret
    ];
  
    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
  
    $response = curl_exec($ch);
    curl_close($ch);
  
    $data = json_decode($response, true);
  
    if (isset($data['access_token'])) {
      $_SESSION['spotify_access_token'] = $data['access_token'];
      $_SESSION['spotify_refresh_token'] = $data['refresh_token'];
      $_SESSION['spotify_token_expires'] = time() + $data['expires_in'];
  
      $this->fetchSpotifyUserProfile($data['access_token']);

      header('Location: ?command=home');
      exit();
    } else {
      echo "Error retrieving access token:<br><pre>" . print_r($data, true) . "</pre>";
    }
  }

  private function fetchSpotifyUserProfile($accessToken) {
    $ch = curl_init('https://api.spotify.com/v1/me');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $accessToken
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $user = json_decode($response, true);
    if (isset($user['display_name']) && isset($user['email'])) {
      $_SESSION['name'] = $user['display_name'];
      $_SESSION['curuserid'] = $user['id'];
      $_SESSION['email'] = $user['email'];

      $results = $this->db->query("select * from swipeify_users where email = $1;", $user['email']);

      if (empty($results)) {
        $result = $this->db->query("insert into swipeify_users (id, name, email) values ($1, $2, $3);",
        $user['id'], $user['display_name'], $user['email']);

        $this->fetchSpotifySongs($_SESSION['spotify_access_token'], $user['id']);
      }

      // header("Location: ?command=home");
      // return;
    }
  }

  private function fetchSpotifySongs($accessToken, $userId) {
    $offset = 0;
    $hasMore = true;

    while ($hasMore) {
      $url = "https://api.spotify.com/v1/me/tracks?limit=50&offset=$offset";
  
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken
      ]);

      $response = curl_exec($ch);

      $data = json_decode($response, true);
      if (!isset($data['items'])) break;
      foreach ($data['items'] as $item) {
        $track = $item['track'];
        $trackId = $track['id'];
        $trackName = $track['name'];

        $this->db->query("INSERT INTO tracks (spotify_id, name) VALUES ($1, $2) ON CONFLICT DO NOTHING;",
          $trackId, $trackName);
        $this->db->query("INSERT INTO user_tracks (user_id, track_id) VALUES ($1, $2) ON CONFLICT DO NOTHING;",
          $userId, $trackId);

        $album = $track['album'];
        $albumId = $album['id'];
        $albumName = $album['name'];
        $albumImage = $album['images'][0]['url'] ?? '';
  
        $this->db->query("INSERT INTO albums (spotify_id, name, image_url) VALUES ($1, $2, $3) ON CONFLICT DO NOTHING;",
          $albumId, $albumName, $albumImage);

        $this->db->query("INSERT INTO album_tracks (album_id, track_id) VALUES ($1, $2) ON CONFLICT DO NOTHING;",
          $albumId, $trackId);
  
        foreach ($track['artists'] as $artist) {
          $artistId = $artist['id'];
          $artistName = $artist['name'];
  
          $this->db->query("INSERT INTO artists (spotify_id, name) VALUES ($1, $2) ON CONFLICT DO NOTHING;",
            $artistId, $artistName);
  
          $this->db->query("INSERT INTO artist_albums (artist_id, album_id) VALUES ($1, $2) ON CONFLICT DO NOTHING;",
            $artistId, $albumId);
        }
      }

      $offset += 50;
      $hasMore = count($data['items']) === 50;
    }
    header("Location: ?command=home");
    return;
  }  
}