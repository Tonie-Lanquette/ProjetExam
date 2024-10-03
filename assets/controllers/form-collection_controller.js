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
    };
}
