// La fonction a deux paramètres, la lettre et la chaine.
function nbOccurence(letter, chaine) {

    // Mettre la chaine en minuscule
    chaine = chaine.toLowerCase();

    // Diviser la chaine en tableau à partir du séparateur "espace"
    var splitted = chaine.split(' ');
    var result = 0;

    for (var i=0; i < splitted.length; i++){
        // Si le mot a plus d'un caractère
        if (splitted[i].length > 1) {
            // Diviser le mot en tableau à partir de la lettre choisie pour trouver le nombre d'occurences de celle-ci.
            var findOccurence = splitted[i].split(letter);
            // Incrémenter le compteur avec le nombre de la lettre touvé dans le mot.
            result += findOccurence.length - 1;
        }
    }

    // Réponse de la function
    alert("Dans la chaine \"" + chaine + "\", il y a " + result + " occurences de la lettre " + letter + ".");
}

// Initialisation de la chaine
var chaine = "Je travaille a la maison pour faire le test technique de Evaneos";

// Appel de la fonction nbOccurrence
nbOccurence("j", chaine);