import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        findings: Array,
    }
    popup = L.popup();
    latlng = null;

    connect() {
        // Map init
        let map = L.map('map', {
            center: [43.5495051, 2.7590491],
            zoom: 20
        });
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        map.on('click', this.onMapClick.bind(this));

        // Markers init
        const iconRetinaUrl = 'images/marker-icon-2x.png';
        const iconUrl = 'images/marker-icon2.png';
        const shadowUrl = 'images/marker-shadow.png';
        L.Marker.prototype.options.icon = L.icon({
            iconRetinaUrl,
            iconUrl,
            shadowUrl,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize: [41, 41]
        });

        this.findingsValue.forEach((finding) => {
            L.marker([finding.location.latitude, finding.location.longitude]).addTo(map);
        });

        // Popup init
        let newMushroomBtn = document.createElement('button');
        newMushroomBtn.innerHTML = "🍄";
        newMushroomBtn.addEventListener("click", this.dispatchFct.bind(this));
        this.popup.setContent(newMushroomBtn);
    }

    onMapClick(event) {
        this.popup.setLatLng(event.latlng).openOn(event.sourceTarget);
        this.latlng = event.latlng;
    }

    dispatchFct() {
        this.dispatch("addMushroom", {detail: {latlng: this.latlng}})
        this.popup.close();
    }

}
