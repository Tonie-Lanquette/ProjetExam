import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        // test edit presence
        const edit = document.getElementById("edit");
        
        // si oui non execution pour form edit
        if (edit) {
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

        const checkboxes = element.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        // Get the data-const attribute value
        const imageUrl = checkbox.getAttribute('data-const');
        
        // Create an <img> element
        const img = document.createElement('img');
        img.setAttribute('src', imageUrl);
        img.setAttribute('alt', 'Item icon');
        img.setAttribute('class', 'mx-2 mt-1 item-image h-16 w-16'); // You can add your own classes for styling
        
        // Insert the <img> after the checkbox
        checkbox.insertAdjacentElement('afterend', img);
        });
    };
}
