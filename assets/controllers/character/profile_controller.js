import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ "body" ];

    // static values = {
    //     defaultUrl: String
    // };

    close(event){
        this.bodyTarget.outerHTML = "";
    }
}