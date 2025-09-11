import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["detail"]

    toggle(event){
        this.detailTarget.classList.toggle('hidden');
    }
}