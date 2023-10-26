import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        findings: Array,
        landmarks: Array,
    }

    ADD_MUSHROOM_TAG = "add_mushroom";
    SHOW_MUSHROOM_TAG = "show_mushroom";
    ADD_LANDMARK_TAG = "add_landmark";
    SHOW_LANDMARK_TAG = "show_landmark";

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
            let latlng = [finding.location.latitude, finding.location.longitude];
            L.marker(latlng)
                .addTo(map)
                .on('click', this.dispatchFct.bind(this, this.SHOW_MUSHROOM_TAG, finding.id))
        });

        this.landmarksValue.forEach((landmark) => {
            let latlng = [landmark.location.latitude, landmark.location.longitude];
            L.marker(latlng)
                .addTo(map)
                .on('click', this.dispatchFct.bind(this, this.SHOW_LANDMARK_TAG, landmark.id))
        });

        // Popup init
        let newMushroomBtn = document.createElement('button');
        newMushroomBtn.innerHTML = "🍄";
        newMushroomBtn.addEventListener('click', this.dispatchFct.bind(this, this.ADD_MUSHROOM_TAG));
        let newLandmarkBtn = document.createElement('button');
        newLandmarkBtn.innerHTML = "📍";
        newLandmarkBtn.addEventListener('click', this.dispatchFct.bind(this, this.ADD_LANDMARK_TAG));
        let container = document.createElement('div');
        container.appendChild(newMushroomBtn);
        container.appendChild(newLandmarkBtn);
        this.popup.setContent(container);
    }

    onMapClick(event) {
        this.popup.setLatLng(event.latlng).openOn(event.sourceTarget);
        this.latlng = event.latlng;
    }

    dispatchFct(type, id) {
        this.dispatch('openModal', {
            detail: {
                type: type,
                latlng: this.latlng,
                id: id
            }
        });
        this.popup.close();
    }

}
