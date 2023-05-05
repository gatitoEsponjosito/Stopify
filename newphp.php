
<?php
// Connect to database and fetch data for songs
$db_host = 'database-proyecto.cr5eoved3rep.us-east-1.rds.amazonaws.com';
$db_name = 'Stopify';
$db_user = 'admin';
$db_pass = '1Rksg0cv7A01A4tvIgpo';

$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$key_words = "";
$queryBuscaCancion = "CALL searchCancion ('$key_words')";
$stmt = $pdo->query($queryBuscaCancion);
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spotify</title>
  <link rel="stylesheet" href="stylephp.css">
  <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>
</head>
<body>
  <header>
    <nav>
      <div class="logo">
        <a href="#">Spotify</a>
      </div>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Explore</a></li>
        <li><a href="#">Mixes</a></li>
        <li><a href="#">Radio</a></li>
        <li><a href="#">Playlist</a></li>
        <li><a href="#">Albums</a></li>
        <li><a href="#">Tracks</a></li>
        <li><a href="#">Artists</a></li>
        <li><a href="#">Create</a></li>
      </ul>
    </nav>
  </header>
  <main>
  <section class="browser">
  <form action="#">
    <label for="search-input">Search songs:</label>
    <div class="search-wrapper">
      <input type="text" id="search-input" name="search-input" placeholder="Search...">
      <button type="submit"><i class="fas fa-search"></i></button>
    </div>
  </form>
</section>


    <div class="grid-container">
      <?php foreach($songs as $song): ?>
      <div class="grid-item">
        <img src="<?php echo $song['port_path']; ?>" alt="<?php echo $song['titulo']; ?>">
        <h3><?php echo $song['titulo']; ?></h3>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="bottom-bar">
      <div class="bottom-bar-item">
        <img src="https://i.pravatar.cc/60?img=69" alt="Song Cover">
        <div class="bottom-bar-item-details">
          <h4>Beautiful Mistakes</h4>
          <p>Maroon 5 feat. Megan Thee Stallion</p>
        </div>
      </div>
      <div class="bottom-bar-item-controls">
<button><i class="fas fa-step-backward"></i></button>
<button><i class="fas fa-play"></i></button>
<button><i class="fas fa-step-forward"></i></button>
<button><i class="fas fa-volume-up"></i></button>
<input type="range" min="0" max="100" value="50" class="bottom-bar-item-volume-range">
</div>
</div>

  </main>
  
</body>
</html>
