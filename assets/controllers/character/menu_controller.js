import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "selectLink" ];

    static values = {
        defaultUrl: String
    };

    select(event){
        let prev = document.querySelector(".selected-character");
        if(prev){
            prev.classList.remove('bg-gray-400/50', 'selected-character');
        }
        event.target.classList.add('bg-gray-400/50', 'selected-character');
        this.selectLinkTarget.setAttribute("href", this.defaultUrlValue + "?id=" + event.target.dataset.characterId)
    }
}