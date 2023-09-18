<?php

  include 'php/connect.php';

  session_start();

  if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = '';
  };

  include 'php/wishlist_cart.php';

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
  <title>Veranstaltungen</title>
</head>
  <body>
    <!-- header section  -->
    <?php include 'header_and_footer/wine_header.php' ;?>

    <main>
      <section id="tabs" class="events">
            <h1 class="main-title">Veranstaltungen</h1>
            <ul class="tab-list">
              <li class="tab-list-item"><a href="#tab1">Weißwein oder Rotwein</a></li>
              <li class="tab-list-item"><a href="#tab2">Weine aus Bordeaux</a></li>
              <li class="tab-list-item"><a href="#tab3">Weinverkostung</a></li>
            </ul>
            <div id="tab1" class="event1">
              <img src="images/events/red-and-white-wine.jpg" alt="two bottles of red and white wine with glasses" title="beautiful image with two bottles of red and white wine with glasses">
              <h2>Weißwein oder Rotwein, welche Sorte bevorzugst du?</h2>
              <p>Weißwein und Rotwein haben jeweils ihre eigene Persönlichkeit und Aromen. Weiße Weine, die aus grünen oder gelben Trauben hergestellt werden, haben oft einen leichteren und erfrischenden Geschmack. Sie eignen sich perfekt für einen warmen Sommertag oder als Begleitung zu Meeresfrüchten und Geflügel.</p>
              <details >
                <summary>Weiter infos hiere!</summary>
                <p>Im Gegensatz dazu werden Rotweine aus blauen Trauben hergestellt und haben oft einen vollmundigen Geschmack mit mehr Tanninen als Weißweine. Sie eignen sich perfekt für einen gemütlichen Abend zu Hause oder als Begleitung zu rotem Fleisch oder kräftigem Käse. Unabhängig davon, ob Sie ein Weißwein- oder Rotweinliebhaber sind, gibt es eine Vielzahl von Weinen zur Auswahl, die zu jedem Anlass passen. Die bekanntesten Weißweinsorten sind Chardonnay, Sauvignon Blanc und Riesling, während Cabernet Sauvignon, Merlot und Pinot Noir einige der bekanntesten Rotweinsorten sind. Wir laden Sie ein, unsere Weinauswahl zu erkunden und die Aromen und Texturen von Weiß- und Rotweinen zu genießen. <br> Prost!</p>
              </details>
            </div>
            
            <div id="tab2" class="event2">
              <img src="images/events/bordeaux.jpg" alt="Place de la Bourse in Bordeaux" title="Place de la Bourse in Bordeaux">
              <h2>Weine aus Bordeaux</h2>
              <p>Herzlich willkommen zu unserem Wein-Event, bei dem wir uns auf die Weine der Bordeaux-Region konzentrieren. Bordeaux-Weine sind weltweit bekannt für ihre hohe Qualität und einzigartigen Geschmacksnoten.</p>
              <details >
                <summary>Weiter infos hiere!</summary>
                <p>Die Bordeaux-Region ist die größte Weinregion Frankreichs und bietet eine große Vielfalt an Weinen, die alle aus verschiedenen Rebsorten hergestellt werden. Die Mischung aus den wichtigsten Rebsorten, Merlot, Cabernet Sauvignon und Cabernet Franc, ist das Geheimnis der Bordeaux-Weine und gibt ihnen ihren charakteristischen Geschmack und ihre Komplexität. Die Weine werden in verschiedene Kategorien eingeteilt, abhängig von der Qualität und dem Alter. Die bekanntesten Kategorien sind die "Crus Classés" und die "Premiers Crus". Diese Weine sind bei Sammlern und Weinliebhabern auf der ganzen Welt sehr begehrt. Bordeaux-Weine sind auch bekannt dafür, mit der Zeit zu altern und an Komplexität und Reife zu gewinnen. Sie eignen sich hervorragend für die Lagerung und können für Jahrzehnte aufbewahrt werden. Wir hoffen, dass Sie die Bordeaux-Weine genießen werden und bedanken uns für Ihre Aufmerksamkeit.</p>
              </details>
            </div>
            
            <div id="tab3" class="event3">
              <iframe src="https://www.youtube.com/embed/dWWNjjlut84" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
              <h2>Weinverkostung</h2>
              <p>Wir freuen uns, Sie zu unserer Weinverkostung einzuladen. Entdecken Sie eine Vielzahl von Weinen aus verschiedenen Regionen und Rebsorten und genießen Sie einzigartige Aromen und Geschmacksrichtungen. Unsere erfahrenen Sommeliers führen Sie durch die Verkostung und erklären Ihnen die Herkunft, den Produktionsprozess und die Merkmale jedes Weins. </p>
              <details>
                <summary>Weiter infos hiere!</summary>
                <p>Sie werden lernen, wie man Wein richtig degustiert und welche Paarungen am besten zu jedem Wein passen. Sie haben die Möglichkeit, einige der besten Weine der Welt zu probieren und zu erfahren, was sie so besonders macht. Von fruchtigen Weißweinen bis hin zu kräftigen Rotweinen haben wir für jeden Geschmack etwas zu bieten. Unsere Weinverkostung ist eine großartige Gelegenheit, um mehr über Wein zu erfahren und ihn auf eine neue Art und Weise zu genießen. Wir hoffen, Sie bald bei uns begrüßen zu dürfen und gemeinsam eine wunderbare Weinreise zu erleben. <br> Prosit!</p>
              </details>
            </div>

      </section>
    </main>

  <!--the footer (the same like the navigation bar)-->
  <?php include 'header_and_footer/wine_footer.php' ;?>
  <!-- javaScript and jQuery links  -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="scripts/script.js"></script>
  </body>
</html>
