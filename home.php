
<?php
session_start(); // Nécessaire pour accéder aux sessions

if (!isset($_SESSION['id'])) {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/postPage/postPage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Tiny5&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div id="postBgBlur">
      <div id="postBg">
        <div id="postImg">
          <img src="#">
        </div>
        <div id="postInfo">
          <div id="postTitle">
            <span>test</span>
          </div>
          <div id="postAdress">
            <span>test</span>
          </div>
          <div id="postPrice">
            <span>test</span>
          </div>
          <div id="postDesc">
            <span>test</span>
          </div>
        </div>
      </div>
    </div>

    <div id="uiBox">
        <header id="uiHeader">
            <img src="assets/img/logotransparent.png" id="appLogo">
            <div id="headerBox">
                <div id="adBoxx">
                    <img src="assets/img/nerf_ad.png">
                </div>
                <button id="postCreateBtn" class="button" onclick="window.location.href = './addPostV.php'">
                    Créer un post
                </button>
                <button id="myPostsBtn" class="button">
                    <img src="assets/img/briefcase.png">
                </button>
                <button id="notificationBtn" class="button">
                    <img src="assets/img/notification.png">
                </button>
                <button id="profileBtn" class="button">
                    <img src="assets/img/account.png">
                </button>
            </div>
        </header>

        <main>
            <div id="uiMain">
                
            </div>
            <div id="uiSide">
                <div id="filterBox">
                    <input id="searchFilterInp" placeholder="Toulouse 31000">
                    <input id="radiusFilterInp" type="range">
                    <select id="typeFilterInp">
                        <option value="TOUT">Tout</option>
                        <option value="TRAVAUX_MANUELS">Travaux manuels</option>
                        <option value="SOUTIEN_SCOLAIRE">Soutien scolaire</option>
                        <option value="TECHNOLOGIE">Technologie</option>
                        <option value="LANGUES">Langues</option>
                        <option value="SERVICE_A_LA_PERSONNE">Service à la personne</option>
                        <option value="LIVRAISON">Livraison</option>
                        <option value="TRANSPORT">Transport</option>
                        <option value="ANIMAUX">Animaux</option>
                        <option value="JARDIN">Jardin</option>
                        <option value="MENAGE">Ménage</option>
                        <option value="TRAVAUX">Travaux</option>
                    </select>
                </div>
                <div id="scrollBox">
                    <div class="postSelectBox">
                        <div id="postPreviewBox">
                            <img src="assets/img/nerf_ad.png">
                        </div>
                        <div id="postNameBox">
                            <span>dolor</span>
                        </div>
                        <div id="postPriceBox">
                            <span>ipsum</span>
                        </div>
                        <div id="postDescBox">
                            <span>lorem</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
      // 1) Fonction asynchrone pour récupérer toutes les annonces
      async function get_all_annonce() {
        const response = await fetch(`./bd_php/get_post.php`);
        const data = await response.json(); 
        // data devrait être un tableau d'objets, ex :
        // [
        //   { id: "1", user_id: "1", adress: "4 hameau ...", type: "JARDIN", latitude: "43.60", longitude: "1.44", ... },
        //   { ... },
        // ]
        return data;
      }
      // 2) Initialisation de la carte
      async function initMap() {
        // On récupère les annonces avant de créer les marqueurs
        const annonces = await get_all_annonce();
        // Coordonnées du centre de la carte (ex: Toulouse)
        const centerCoords = { lat: 43.6045, lng: 1.4442 };
        // Exemple d'icône personnalisée
        const iconShrek = {
          url: "./assets/img/shrek.png",       // Chemin vers l'image
          scaledSize: new google.maps.Size(50, 50),
          anchor: new google.maps.Point(25, 50)
        };
        // Création de la carte
        const map = new google.maps.Map(document.getElementById("uiMain"), {
          zoom: 13,
          center: centerCoords
        });
        // 3) Pour chaque annonce, on crée un marqueur
        annonces.forEach((annonce) => {
          // Convertir les lat/long en float (si besoin)
          const lat = parseFloat(annonce.latitude);
          const lng = parseFloat(annonce.longitude);
          // Créer le marqueur
          const marker = new google.maps.Marker({
            position: { lat, lng },
            map: map,
            title: annonce.type, // ou annonce.titre, selon ce que vous voulez
            icon: {
              url: annonce.image_path,
              scaledSize: new google.maps.Size(50, 50),
              anchor: new google.maps.Point(25, 50)
            }     // optionnel, retirez cette ligne si vous ne voulez pas d'icône custom
          });
          // Construire le contenu de l'infoWindow (HTML au clic)
          const infoContent = `
            <div style="min-width: 200px;">
            <h3>${annonce.titre}</h3>
            <img src="${annonce.image_path}" alt="Mon image" style="max-width: 100px; height: auto;">                  <!-- Ajoutez ici tout ce que vous voulez afficher -->
              <p><strong>Type :</strong>${annonce.Type}</p>
              <p><strong>Adresse :</strong> ${annonce.adress} </p>
              <p><strong>Description :</strong> ${annonce.description}</p>
            </div>
          `;
          const infoWindow = new google.maps.InfoWindow({
            content: infoContent,
          });
          marker.addListener("click", () => {
            infoWindow.open({
              anchor: marker,
              map: map,
              shouldFocus: false
            });
          });
        });
      }
    </script>
</body>
<script src="js/main.js"></script>
<script 
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuRA36AzIS5o-83Qx1V6Rc90NXsZRwU4o&callback=initMap"
  async
  defer>
</script>
</html>