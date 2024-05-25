<?php
// Connexion à la base de données
$servername = "localhost"; // Adresse du serveur MySQL
$port = "3306";
$username = "root"; // Nom d'utilisateur MySQL
$password = "root"; // Mot de passe MySQL
$database = "projet_info"; // Nom de la base de données
$conn = new mysqli($servername, $username, $password, $database, $port);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$objet = $_POST['objet'];
$message = $_POST['message'];

// Vérifier si l'adresse e-mail est valide
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("L'adresse e-mail est invalide.");
}

// Préparer et exécuter la requête SQL pour insérer les données dans la table
$sql = "INSERT INTO formulaire_contact (nom, prenom, telephone, email, objet, msg) VALUES ('$nom', '$prenom', '$telephone', '$email', '$objet', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "Votre message a été envoyé avec succès.";
} else {
    echo "Une erreur s'est produite lors de l'envoi du message : " . $conn->error;
}

// Fermer la connexion à la base de données
$conn->close();

// Contenu du message
$to = "contact.cy.laws@gmail.com"; // Adresse e-mail de réception
$subject = "Nouveau message de $nom $prenom"; // Objet de l'e-mail
$body = "Nom: $nom\nPrénom: $prenom\nTéléphone: $telephone\nE-mail: $email\nObjet: $objet\nMessage: $message\n\nMerci de nous avoir contactés. Notre équipe fera de son mieux pour apporter une réponse dans un délai de 48 heures."; // Corps de l'e-mail

// En-têtes
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envoyer l'e-mail
if (mail($to, $subject, $body, $headers)) {
    echo "Merci de nous avoir contactés. Notre équipe fera de son mieux pour apporter une réponse dans un délai de 48 heures.";
} else {
    echo "Une erreur s'est produite lors de l'envoi du message.";
}
?>

