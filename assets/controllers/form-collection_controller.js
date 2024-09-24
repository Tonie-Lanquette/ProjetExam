import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.index = this.element.childElementCount;
        const btn = document.createElement('button');
        btn.setAttribute('class', 'bg-[#65C986] py-1 px-2 rounded-md mt-8 addButton');
        btn.innerText = 'ajouter un element';
        btn.setAttribute('type', 'button');
        btn.addEventListener('click', this.addElement);
        this.element.append(btn);
        
        // Automatically click the button 3 times to generate the slots
        btn.click(); // First (Starter Items)
        btn.click(); // Second (Core Items)
        btn.click(); // Third (Optional Items)
        
        btn.setAttribute('class', 'hidden'); // Hide the button after adding 3 slots
    }

    addElement = (e) => {
        e.preventDefault();
        
        // Create new form element based on the prototype
        const element = document.createRange().createContextualFragment(
            this.element.dataset['prototype'].replaceAll('__name__', this.index)
        ).firstElementChild;
        
        // Add the form element before the button
        this.index++;
        e.currentTarget.insertAdjacentElement('beforebegin', element);
        
        // Set the default selected value for the category dropdown based on the index
        const categorySelect = element.querySelector('select[name$="[category]"]');
        if (categorySelect) {
            switch (this.index - 1) {
                case 0:
                    categorySelect.value = 'starter_items';
                    break;
                case 1:
                    categorySelect.value = 'core_items';
                    break;
                case 2:
                    categorySelect.value = 'optional_items';
                    break;
                default:
                    break;
            }
        }
    };
}
