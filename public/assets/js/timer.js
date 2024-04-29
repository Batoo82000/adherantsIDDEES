"use strict";
let inactivityTime = function () { // définit une fonction anonyme qui est assignée à la variable inactivityTime
    let time; // déclare une variable time qui sera utilisée pour stocker l’identifiant de l’objet retourné par la fonction setTimeout()
    window.onload = resetTimer; //assigne la fonction resetTimer à l’événement onload de l’objet window. Cela signifie que la fonction resetTimer sera exécutée chaque fois que la page est chargée
    document.onmousemove = resetTimer;//assignent la fonction resetTimer aux événements onmousemove et onkeydown de l’objet document. Cela signifie que la fonction resetTimer sera exécutée chaque fois que l’utilisateur bouge la souris ou appuie sur une touche
    document.onkeydown = resetTimer;

    function logout() {
        window.location.href = '/logout'; // redirige l’utilisateur vers la page de déconnexion lorsque celle-ci est appelée
    }

    function resetTimer() { //réinitialise le timer d’inactivité. Elle annule d’abord le précédent timer avec clearTimeout(time), puis définit un nouveau timer avec setTimeout(logout, 1200000). Si l’utilisateur ne bouge pas la souris ou n’appuie pas sur une touche pendant 20 minutes (1200000 millisecondes), la fonction logout sera appelée.
        clearTimeout(time);
        time = setTimeout(logout, 1200000); // 1200000 millisecondes = 20 minutes
    }
};
inactivityTime(); //appelle la fonction inactivityTime qui met en place le système de déconnexion automatique après une période d’inactivité.