<?php
    $host = "localhost";
    $port = "5432";
    $database = "rze7ud";
    $user = "rze7ud";
    $password = "Gc-Mys2-QKHm";
    
//     $host = "db";
//     $port = "5432";
//     $database = "example";
//     $user = "localuser";
//     $password = "cs4640LocalUser!";

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if ($dbHandle) {
        echo "Success connecting to database<br>\n";
    } else {
        die("An error occurred connecting to the database");
    }

    // Drop tables and sequences (that are created later)
    $res  = pg_query($dbHandle, "drop table if exists artists;");
    $res  = pg_query($dbHandle, "drop table if exists albums;");
    $res  = pg_query($dbHandle, "drop table if exists tracks;");
    $res  = pg_query($dbHandle, "drop table if exists swipeify_users;");
    $res  = pg_query($dbHandle, "drop table if exists artist_albums;");
    $res  = pg_query($dbHandle, "drop table if exists album_tracks;");
    $res  = pg_query($dbHandle, "drop table if exists user_tracks;");

    // Create tables
    $res  = pg_query($dbHandle, "create table artists (
            spotify_id  text primary key,
            name        text);");
    $res  = pg_query($dbHandle, "create table albums (
            spotify_id  text primary key,
            name        text,
            image_url   text);");
    $res  = pg_query($dbHandle, "create table tracks (
            spotify_id  text primary key,
            name        text);");
    $res  = pg_query($dbHandle, "create table swipeify_users (
            id          text primary key,
            name        text,
            email       text);");
    $res  = pg_query($dbHandle, "create table artist_albums (
            artist_id   text,
            album_id    text,
            PRIMARY KEY (artist_id, album_id));");
    $res  = pg_query($dbHandle, "create table album_tracks (
            album_id    text,
            track_id    text,
            PRIMARY KEY (album_id, track_id));");
    $res  = pg_query($dbHandle, "create table user_tracks (
            user_id     text,
            track_id    text,
            PRIMARY KEY (user_id, track_id));");


    // Prepare a statement, then execute it repeatedly
    // This is a more effient method than repeatedly calling query()

    // Artists
//     $res  = pg_prepare($dbHandle, "insert_artist", "INSERT INTO artists (spotify_id, name) VALUES ($1, $2);");
//     $res  = pg_execute($dbHandle, "insert_artist", ['6l3HvQ5sa6mXTsMTB19rO5', 'J. Cole']);
//     $res  = pg_execute($dbHandle, "insert_artist", ['0du5cEVh5yTK9QJze8zA0C', 'Bruno Mars']);
//     $res  = pg_execute($dbHandle, "insert_artist", ['1HY2Jd0NmPuamShAr6KMms', 'Lady Gaga']);

//     // Albums
//     $res  = pg_prepare($dbHandle, "insert_album", "INSERT INTO albums (spotify_id, name, image_url) VALUES ($1, $2, $3);");
//     $res  = pg_execute($dbHandle, "insert_album", ['0UMMIkurRUmkruZ3KGBLtG', '2014 Forest Hills Drive', 'https://example.com/2014_Forest_Hills_Drive.jpg']);
//     $res  = pg_execute($dbHandle, "insert_album", ['10FLjwfpbxLmW8c25Xyc2N', 'Die With A Smile', 'https://example.com/Die_With_A_Smile.jpg']);
//     $res  = pg_execute($dbHandle, "insert_album", ['1uyf3l2d4XYwiEqAb7t7fX', 'Doo-Wops & Hooligans', 'https://example.com/Doo-Wops_&_Hooligans.jpg']);

//     // Tracks
//     $res  = pg_prepare($dbHandle, "insert_track", "INSERT INTO tracks (spotify_id, name) VALUES ($1, $2);");
//     $res  = pg_execute($dbHandle, "insert_track", ['2e3Ea0o24lReQFR4FA7yXH', 'Love Yourz']);
//     $res  = pg_execute($dbHandle, "insert_track", ['2plbrEY59IikOBgBGLjaoe', 'Die With a Smile']);
//     $res  = pg_execute($dbHandle, "insert_track", ['1ExfPZEiahqhLyajhybFeS', 'The Lazy Song']);

//     // Users
//     // $res  = pg_prepare($dbHandle, "insert_user", "INSERT INTO swipeify_users (id, name, email, password) VALUES ($1, $2, $3, $4);");
//     // $res  = pg_execute($dbHandle, "insert_user", [1, 'Billy', 'billy@example.com', 'password1']);
//     // $res  = pg_execute($dbHandle, "insert_user", [2, 'Bob', 'bob@example.com', 'password12']);
//     // $res  = pg_execute($dbHandle, "insert_user", [3, 'Joe', 'joe@example.com', 'password123']);

//     // Artist_Albums (Linking artists to albums)
//     $res  = pg_prepare($dbHandle, "insert_artist_album", "INSERT INTO artist_albums (artist_id, album_id) VALUES ($1, $2);");
//     $res  = pg_execute($dbHandle, "insert_artist_album", ['6l3HvQ5sa6mXTsMTB19rO5', '0UMMIkurRUmkruZ3KGBLtG']); // J. Cole & 2014 Forest Hills Drive
//     $res  = pg_execute($dbHandle, "insert_artist_album", ['0du5cEVh5yTK9QJze8zA0C', '10FLjwfpbxLmW8c25Xyc2N']); // Bruno Mars & Die With a Smile
//     $res  = pg_execute($dbHandle, "insert_artist_album", ['1HY2Jd0NmPuamShAr6KMms', '10FLjwfpbxLmW8c25Xyc2N']); // Lady Gaga & Die With a Smile
//     $res  = pg_execute($dbHandle, "insert_artist_album", ['0du5cEVh5yTK9QJze8zA0C', '1uyf3l2d4XYwiEqAb7t7fX']); // Bruno Mars & Doo-Wops & Hooligans

//     // Album_Tracks (Linking albums to tracks)
//     $res  = pg_prepare($dbHandle, "insert_album_track", "INSERT INTO album_tracks (album_id, track_id) VALUES ($1, $2);");
//     $res  = pg_execute($dbHandle, "insert_album_track", ['0UMMIkurRUmkruZ3KGBLtG', '2e3Ea0o24lReQFR4FA7yXH']); // 2014 Forest Hills Drive & Love Yourz
//     $res  = pg_execute($dbHandle, "insert_album_track", ['10FLjwfpbxLmW8c25Xyc2N', '2plbrEY59IikOBgBGLjaoe']); // Die With a Smile & Die With a Smile
//     $res  = pg_execute($dbHandle, "insert_album_track", ['1uyf3l2d4XYwiEqAb7t7fX', '1ExfPZEiahqhLyajhybFeS']); // Doo-Wops & Hooligans & The Lazy Song

//     // User_Tracks (Users' saved tracks)
//     $res  = pg_prepare($dbHandle, "insert_user_track", "INSERT INTO user_tracks (user_id, track_id) VALUES ($1, $2);");
//     $res  = pg_execute($dbHandle, "insert_user_track", [1, '2e3Ea0o24lReQFR4FA7yXH']); // Billy & Love Yourz
//     $res  = pg_execute($dbHandle, "insert_user_track", [1, '2plbrEY59IikOBgBGLjaoe']); // Bob & Die With a Smile
//     $res  = pg_execute($dbHandle, "insert_user_track", [1, '1ExfPZEiahqhLyajhybFeS']); // Joe & The Lazy Song

//     echo "Done!";
