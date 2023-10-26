import {Controller} from '@hotwired/stimulus';
import {Modal} from "bootstrap";
import $ from 'jquery';

export default class extends Controller {
    static targets = ['modal', 'modalBody', 'modalSaveBtn'];
    static values = {
        formUrlAddMushroom: String,
        formUrlShowMushroom: String,
        formUrlAddLandmark: String,
        formUrlShowLandmark: String,
    }

    async openModal({detail: {type, latlng, id}}) {
        const modalBody = this.modalBodyTarget;
        const modal = new Modal(this.modalTarget);
        modalBody.innerHTML = 'Loading...';
        modal.show();

        let url = "";
        switch (type) {
            case "add_mushroom":
                modalBody.innerHTML = await $.ajax(this.formUrlAddMushroomValue);
                document.getElementById("finding_location_latitude").value = latlng.lat;
                document.getElementById("finding_location_longitude").value = latlng.lng;
                this.modalSaveBtnTarget.addEventListener("click", () => {
                    modalBody.querySelector("form").submit();
                });
                break;
            case "show_mushroom":
                this.url = this.formUrlShowMushroomValue;
                url = url.slice(0, -1) + id;
                modalBody.innerHTML = await $.ajax(url);
                break;
            case "add_landmark":
                modalBody.innerHTML = await $.ajax(this.formUrlAddLandmarkValue);
                document.getElementById("landmark_location_latitude").value = latlng.lat;
                document.getElementById("landmark_location_longitude").value = latlng.lng;
                this.modalSaveBtnTarget.addEventListener("click", () => {
                    modalBody.querySelector("form").submit();
                });
                break;
            case "show_landmark":
                url = this.formUrlShowLandmarkValue;
                url = url.slice(0, -1) + id;
                modalBody.innerHTML = await $.ajax(url);
                break;
        }


    }
}
