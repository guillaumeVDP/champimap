import {Controller} from '@hotwired/stimulus';
import {Modal} from "bootstrap";
import $ from 'jquery';

export default class extends Controller {
    static targets = ['modal', 'modalBody', 'modalSaveBtn'];
    static values = {
        formUrl: String,
    }

    async openModal({detail: {latlng}}) {
        console.log(latlng)
        const modalBody = this.modalBodyTarget;
        modalBody.innerHTML = 'Loading...';
        const modal = new Modal(this.modalTarget);
        modal.show();
        modalBody.innerHTML = await $.ajax(this.formUrlValue);
        document.getElementById("finding_location_latitude").value = latlng.lat;
        document.getElementById("finding_location_longitude").value = latlng.lng;
        this.modalSaveBtnTarget.addEventListener("click", () => {
            modalBody.querySelector("form").submit();
        });
    }
}
