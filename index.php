<?php

  include 'php/connect.php';

  session_start();

  if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = '';
  };

  include 'php/wishlist_cart.php';

  // Check if the form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get the email address from the form
      $email = $_POST["email"];

      // Validate the email address
      if (htmlspecialchars(filter_var($email, FILTER_VALIDATE_EMAIL))) {
          // Database insertion logic
          try {
              // Create a database connection
              $pdo = new PDO("mysql:host=localhost;dbname=wine_shop", "root", "");
              
              // Set the PDO error mode to exception
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              // Prepare and execute an SQL statement to insert the email
              $sql = "INSERT INTO newsletter (email) VALUES (:email)";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':email', $email);

              if ($stmt->execute()) {
                  // Provide a success message
                  $message = "Thank you for subscribing to our newsletter!";
              } else {
                  $message = "Error: " . $stmt->errorInfo()[2];
              }
              
          } catch (PDOException $e) {
              // Handle any database errors
              $message = "Error: " . $e->getMessage();
          }
      } else {
          // Invalid email address
          $message = "Please enter a valid email address.";
      }
  } else {
      // If the form was not submitted, redirect or provide an error message
      $message = "Form submission error.";
  }

?>

<!DOCTYPE html>
<html lang="de" id="top">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- custom css file -->
  <link rel="stylesheet" href="styles/style.css">
  <!-- swiper cdn link -->
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" >
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- wine glass icon link -->
  <link rel="icon" type="image/x-icon" href="images/wine-glass.png">
  <title>Wine-Shop</title>
</head>
  <body>
    <!-- header section  -->
    <?php include 'header_and_footer/wine_header.php' ;?>
    <!--this section is the top site with the bottle of wine in the background and the text with the products link (button)-->
    <section class="top-site">
      <h1>Weine und Weinveranstaltungen</h1>
      <a href="#subscription">&#128315; weiter &#128315;</a>
    </section>
    <section class="mobile-top-site">
      <h1>Willkommen in unserem Weinladen</h1>
      <a href="#subscription">Weiter</a>
    </section>
    
    <!-- cards section -->
    <section class="cards">
      <div class="card1">
        <img src="images/png/hourglass.png" alt="">
        <h3>Schnellste Lieferung in Europa</h3>
        <p>Mindestens 2 Werktage</p>
      </div>
      <div class="card2">
        <img src="images/png/thumbs-up.png" alt="">
        <h3>Von unseren Kunden anerkannt</h3>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star"></span>
      </div>
      <div class="card3">
        <img src="images/png/globe.png" alt="">
        <h3>Wir liefern weltweit</h3>
      </div>
    </section>

    <section id="subscription" class="abo-events">
    <!--here is a small title of the side in h2 to welcome in the main contents ( wine abo, events, instagram following and newsletter subscription)-->
      <h2 class="main-title">Wir lieben es, Ihnen das Beste des Weines zu zeigen</h2>
      <div class="flip-card">
        
        <!--this section is the content with the Subscription text and link (button) on the left and the picture on the right-->
        <div class="flip-card-inner">
          <div class="weinabo">
            <img src="images/wine-bottle-velvet-rich.jpg" alt="A bottle of wine on a beautiful rich velvet blanket" title="A delicious red wine on a beautiful rich red velvet blanket">
            <div class="sectiontxt">
              <h2>Wein Abo</h2>
              <p>Wählen Sie Ihre Farbe und Ihren Stil und wir kümmern uns jede Woche oder jeden Monat um den Rest. Mit einer großen Auswahl an Weinen können unsere Sommeliers auch die härtesten Kunden zufrieden stellen.</p>
            </div>
          </div>
          <!--this section is the content with the events img on the left side and the text with the link (button) on the right side of the page-->
          <div class="veranstaltung">
            <img src="images/wine-bottles.jpg" alt="A photo of bottles on the shelf." title="A celler with wine bottles.">
            <div class="sectiontxt">
              <h2>Veranstaltungen</h3>
              <p>Jeden Monat bieten wir unseren Gästen eine Liste von Veranstaltungen, von denen sie nicht unzufrieden und unwissend nach Hause können.</p>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!--this section is with the global coverage  -->
    <section class="global">
      <div class="global-coverage">
        <h2>Globale Abdeckung</h2>
        <p>Wir liefern unseren Kunden und Mitgliedern qualitativ hochwertigen Wein so schnell wie möglich, damit sie die schönsten Momente genießen können.</p>
        <img src="images/world-map2.jpg" alt="world map with our delivery points">
        <spam class="red-dot">&#128308; Wo Sie uns finden.</spam>
      </div>
    </section>

    <!-- this section covers the customers review cards  -->
    <section class="reviews">
      <div class="review">
        <h2>Wird von Tausenden zufriedener Kunden verwendet</h2>
        <h4>Dies sind die Geschichten unserer Kunden, die unsere köstlichen Weinsortimente genossen haben.</h4>
        <div class="review-cards">
          <div class="review-card1">
            <img src="images/people/poeple1.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Emily Johnson</h3>
              <p class="city">New York City, USA</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              <p>"Absolutely loved the wine selection at this shop! The variety and quality were outstanding. I'll definitely be coming back for more."</p>
            </div>
          </div>
          <div class="review-card2">
            <img src="images/people/poeple2.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Michael Rodriguez</h3>
              <p class="city">Los Angeles, USA</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              <p>"Great experience shopping for wines here. The staff was knowledgeable and helped me find the perfect bottle for a special occasion."</p>
            </div>
          </div>
          <div class="review-card3">
            <img src="images/people/poeple3.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Sarah Thompson</h3>
              <p class="city">Toronto, Canada</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p>"Visited this wine shop during my trip to Toronto and was pleasantly surprised by their curated collection. The ambiance and service were top-notch."</p>
            </div>
          </div>
          <div class="review-card4">
            <img src="images/people/poeple4.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Jessica Martinez</h3>
              <p class="city">Paris, France</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p> "Un magasin de vin incroyable! The wine selection transported me to different regions of France. A must-visit for any wine lover."</p>
            </div>
          </div>
          <div class="review-card5">
            <img src="images/people/poeple5.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Emma Lee</h3>
              <p class="city">Vancouver, Canada</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p>"As a wine enthusiast, I can confidently say that this shop exceeded my expectations. The staff's expertise and the range of options made my visit enjoyable."</p>
            </div>
          </div>
          <div class="review-card6">
            <img src="images/people/poeple6.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Daniel Wilson</h3>
              <p class="city">London, United Kingdom</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p> "A gem of a wine shop in London. The recommendations from the staff were on point, and I discovered some new favorites."</p>
            </div>
          </div>
          <div class="review-card7">
            <img src="images/people/poeple7.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Olivia Davis</h3>
              <p class="city">Tokyo, Japan</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p>"このワインショップは素晴らしいです！日本にいながら、世界中のワインを楽しむことができました。また行きたいと思います。"</p>
            </div>
          </div>
          <div class="review-card8">
            <img src="images/people/poeple8.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Anette Anderson</h3>
              <p class="city">Melbourne, Australia</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p>"This wine shop had an impressive selection of wines from around the world. The staff's passion for wine was evident, and their recommendations were spot on."</p>
            </div>
          </div>
          <div class="review-card9">
            <img src="images/people/poeple9.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name">Sophia Müller</h3>
              <p class="city">Berlin, Germany</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star"></span>
              <p>"Ich habe diesen Weinkeller besucht, während ich Berlin erkundet habe. Die Sammlung präsentierte eine Vielzahl von deutschen und internationalen Weinen. Ein wunderbares Erlebnis!"</p>
            </div>
          </div>
          <div class="review-card10">
            <img src="images/people/poeple10.jpg" alt="portrait of a person">
            <div class="perdon-detail">
              <h3 class="name"> William Taylor</h3>
              <p class="city"> Beijing, China</p>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <span class="fa fa-star checked"></span>
              <p> "在这家酒店购买了一些葡萄酒，品种繁多，品质很高。店员非常友好，我会推荐给我的朋友们。"</p>
            </div>
          </div>
        </div>
      </div> 
    </section>    

    <!-- this section is only social media / instagram/ newsletter -->
    <section class="socialmedia">
      <a href="https://www.instagram.com/">follow us <br> @ instagram</a>
      <form action="" method="POST" class="newsletter">
        <h4>Newsletter Sign Up</h4>
        <label for="email">E-Mail Addresse: *</label>
        <input type="text" id="email" name="email" placeholder="beispiel@beisiel.de" required>
        <button type="submit" value="email">Abonnieren</button>
      </form>
    </section>

    <!--the footer (the same like the navigation bar)-->
    <?php include 'header_and_footer/wine_footer.php' ;?>
    <!-- javaScript and jQuery links  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="scripts/script.js"></script>
  </body>
</html>