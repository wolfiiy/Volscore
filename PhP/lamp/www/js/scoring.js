/***********************
 * JS pour la page scoring
 **********************/
    
        

    var affichage1 = true;

    const button1 = document.getElementById("changement1");

    button1.addEventListener("click", (event) => {

    AfficherBouton(affichage1,1);

    if(affichage1){affichage1 = false;}
    else{affichage1 = true;}

    });

    var affichage2 = true;

    const button2 = document.getElementById("changement2");
    
    button2.addEventListener("click", (event) => {

    AfficherBouton(affichage2,2);

    if(affichage2){affichage2 = false;}
    else{affichage2 = true;}

    });

    function AfficherBouton(value,team){
        console.log(value);
        if(value){
            const button = document.getElementById("changer" + team);
            button.hidden = false
            const div = document.getElementById("listejoueur" + team);
            div.hidden = false

            // Sélectionner tous les éléments ayant un data-set="1"
            var elements = document.querySelectorAll('[data-equipe="' + team + '"]');
            console.log(elements);
            // Boucler sur les éléments sélectionnés
            elements.forEach(function(element) {
            // Vérifier si l'élément est une balise <option>
            if (element.tagName === 'OPTION' || element.tagName === 'SELECT') {
                // Modifier la classe de l'élément
                // Remplacer toutes les classes existantes par 'nouvelle-classe'
                //element.className = 'add';
                
                // Ou, pour ajouter une classe sans enlever les existantes
                element.classList.add('add');
                
                // Si vous souhaitez supprimer une classe spécifique
                // element.classList.remove('classe-a-supprimer');
            }
            });

        }else{
            const button = document.getElementById("changer" + team);
            button.hidden = true
            const div = document.getElementById("listejoueur" + team);
            div.hidden = true
            location.reload();

            // Sélectionner tous les éléments ayant un data-set="1"
            var elements = document.querySelectorAll('[data-equipe="' + team + '"]');

            // Boucler sur les éléments sélectionnés
            elements.forEach(function(element) {
            // Vérifier si l'élément est une balise <option>
            if (element.tagName === 'OPTION' || element.tagName === 'SELECT') {
                // Modifier la classe de l'élément
                // Remplacer toutes les classes existantes par 'nouvelle-classe'
                //element.className = 'add';
                
                // Ou, pour ajouter une classe sans enlever les existantes
                // element.classList.add('nouvelle-classe');
                
                // Si vous souhaitez supprimer une classe spécifique
                element.classList.remove('add');
            }
            });
        }
    }

    /* Méthode qui est appeller pour  */
    function onDragStart(event) {

        event.dataTransfer.setData('text/plain', event.target.id);

    }

    /* Méthode qui est appeller pour  */
    function onDragOver(event) {

        event.preventDefault();

    }

    /* Méthode qui est appeller pour  */
    function onDrop(event) {

        // Element Drag sur l'autre objet
        const draggableElement = document.getElementById(event.dataTransfer.getData('text'));
        // Element qui est en dessous
        const dropzone = event.target;

        // Si l'élément n'est pas de la meme equipe enleve
        if(draggableElement.dataset.equipe != dropzone.dataset.equipe){return}

        if(dropzone.value != 0 && dropzone.id != "spawn"){

            // Cas de figure
            console.log(dropzone.id + " " + draggableElement.id)
            // drop et element sont des select
            if(dropzone.dataset.type == "select" && draggableElement.dataset.type == "select"){
                console.log("deplace3");
                
                var un = draggableElement.options[0];
                var deux = dropzone.options[0];

                dropzone.options[0] = un;
                draggableElement.options[0] = deux;
                
            }
            // drop est un select et element non
            if(dropzone.dataset.type == "option" && draggableElement.dataset.type == "select"){
                console.log("deplace2");
                dropzone.parentNode.appendChild(draggableElement.options[0]);

                draggableElement.appendChild(dropzone);
                event.dataTransfer.clearData();
            }
            // contraire
            if(dropzone.dataset.type == "select" && draggableElement.dataset.type == "option"){
                console.log("A2");
                draggableElement.parentNode.appendChild(dropzone.options[0]);

                dropzone.appendChild(draggableElement);
                event.dataTransfer.clearData();
            }
            // Pour finir les deux sont pas des selects
            if(dropzone.dataset.type == "option" && draggableElement.dataset.type == "option"){
                console.log("A1");
                var draggableElementvalue = draggableElement.value;
                var draggableElementtext = draggableElement.textContent;

                var dropzonetext = dropzone.textContent;
                var dropzonevalue = dropzone.value;

                dropzone.value = draggableElementvalue;
                dropzone.textContent = draggableElementtext;

                draggableElement.value = dropzonevalue;
                draggableElement.textContent = dropzonetext;
            }
        }
        else if(draggableElement.dataset.type == "select"){
        //let select = document.getElementById(draggableElement.id);
            console.log("A");
            let newOption = document.createElement('option');
            
            //console.log(draggableElement.options[1]);
            newOption.value = draggableElement.value;
            newOption.id = draggableElement.options[0].id;
            newOption.className = "example-draggable";
            newOption.setAttribute('draggable', "true");
            newOption.setAttribute('ondragstart', "onDragStart(event);");
            newOption.selected = true;
            newOption.textContent = draggableElement.textContent;
            newOption.dataset.equipe = draggableElement.dataset.equipe;
            newOption.dataset.type = "option";
            dropzone.appendChild(newOption);

            draggableElement.options.length = 0;
        }
        else{
            dropzone.appendChild(draggableElement);
            event.dataTransfer.clearData();
        }
    }

    /* Méthode qui les select de 1 à 6 en false pour permettre d'envoyer en $_POST*/
    function Enable(){

        // Sélectionner tous les éléments <select> de la page
        var selects = document.querySelectorAll('select');

        // Parcourir chaque élément <select>
        selects.forEach(function(select) {
            // Retirer l'attribut 'disabled'
            select.removeAttribute('disabled');
        });
    }