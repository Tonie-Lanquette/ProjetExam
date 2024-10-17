import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        // Test de la présence de l'élément avec l'ID "edit"
        const edit = document.getElementById("edit");
        
        // Si "edit" existe, on ignore l'ajout de nouveaux éléments mais on exécute toujours la génération des images
        if (edit) {
            this.generateImages();
            return; 
        }

        this.index = this.element.childElementCount;
        const btn = document.createElement('button');
        btn.setAttribute('class', 'bg-[#65C986] py-1 px-2 rounded-md mt-8 addButton');
        btn.innerText = 'ajouter un element';
        btn.setAttribute('type', 'button');
        btn.addEventListener('click', this.addElement);
        this.element.append(btn);
        
        btn.click();
        btn.click();
        btn.click();
        
        btn.setAttribute('class', 'hidden');
    }

    addElement = (e) => {
        e.preventDefault();
        
        const element = document.createRange().createContextualFragment(
            this.element.dataset['prototype'].replaceAll('__name__', this.index)
        ).firstElementChild;
        
        const falseLabel = document.createElement('p');
        falseLabel.classList.add('font-semibold', 'ml-2', 'text-xl');
        
        this.index++;
        e.currentTarget.insertAdjacentElement('beforebegin', element);
        
        const categoryInput = element.querySelector('input[name$="[category]"]');
        if (categoryInput) {
            switch (this.index - 1) {
            case 0:
                falseLabel.innerText = 'Starter items :';
                categoryInput.value = 'starter_items';
                break;
            case 1:
                falseLabel.innerText = 'Core items :';
                categoryInput.value = 'core_items';
                break;
            case 2:
                falseLabel.innerText = 'Optional items :';
                categoryInput.value = 'optional_items';
                break;
            default:
                break;
            }
        }

        element.insertAdjacentElement('beforebegin', falseLabel);
        this.generateImages(element);
    };

    // Nouvelle méthode pour générer les images sur l'élément donné
    generateImages(element = this.element) {
        const checkboxes = element.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            // Récupérer la valeur de l'attribut data-const
            const imageUrl = checkbox.getAttribute('data-const');
            
            // Créer un élément <img>
            const img = document.createElement('img');
            img.setAttribute('src', imageUrl);
            img.setAttribute('alt', 'Item icon');
            img.setAttribute('class', 'mx-2 mt-1 item-image h-16 w-16'); // Tu peux personnaliser tes classes
            
            // Insérer l'image après la checkbox
            checkbox.insertAdjacentElement('afterend', img);
        });
    }
}
