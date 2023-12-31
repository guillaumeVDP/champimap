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
    map = null;
    latlng = null;
    userMarker = null;

    connect() {
        /********************
         ***** Map init *****
         ********************/
        this.map = L.map('map', {});
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this.map);
        this.map.on('click', this.onMapClick.bind(this));
        this.map.whenReady(this.mapReady.bind(this));
        document.getElementById("map").style.width = window.innerWidth + "px";
        document.getElementById("map").style.height = window.innerHeight + "px";

        /**********************
         **** Markers init ****
         **********************/
        // User
        navigator.geolocation.getCurrentPosition(this.showUserLocation.bind(this), this.noUserLocation.bind(this), {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        });

        // Findings
        const shadowUrl = 'images/marker-shadow.png';
        let iconUrl = 'images/marker-icon-mushroom.png';
        let iconRetinaUrl = 'images/marker-icon-mushroom-2x.png';
        let iconMushroom = L.icon({
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
                .addTo(this.map)
                .setIcon(iconMushroom)
                .on('click', this.dispatchFct.bind(this, this.SHOW_MUSHROOM_TAG, finding.id))
        });

        // Landmarks
        iconUrl = 'images/marker-icon-landmark.png';
        iconRetinaUrl = 'images/marker-icon-landmark-2x.png';
        let iconLandmark = L.icon({
            iconRetinaUrl,
            iconUrl,
            shadowUrl,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize: [41, 41]
        });

        this.landmarksValue.forEach((landmark) => {
            let latlng = [landmark.location.latitude, landmark.location.longitude];
            L.marker(latlng)
                .addTo(this.map)
                .setIcon(iconLandmark)
                .on('click', this.dispatchFct.bind(this, this.SHOW_LANDMARK_TAG, landmark.id))
        });

        /********************
         **** popup init ****
         ********************/
        let newMushroomBtn = document.createElement('button');
        newMushroomBtn.className = "btn-add-popup";
        newMushroomBtn.innerHTML = "🍄";
        newMushroomBtn.addEventListener('click', this.dispatchFct.bind(this, this.ADD_MUSHROOM_TAG));
        let newLandmarkBtn = document.createElement('button');
        newLandmarkBtn.className = "btn-add-popup";
        newLandmarkBtn.innerHTML = "📍";
        newLandmarkBtn.addEventListener('click', this.dispatchFct.bind(this, this.ADD_LANDMARK_TAG));
        let container = document.createElement('div');
        container.appendChild(newMushroomBtn);
        container.appendChild(newLandmarkBtn);
        this.popup.setContent(container);
    }

    mapReady() {
        document.getElementById("map").style.zIndex = "0";
        document.getElementById("splash-screen").style.display = "none";
    }

    showUserLocation(position) {
        const shadowUrl = 'images/marker-shadow.png';
        let iconUrl = 'images/marker-icon.png';
        let iconRetinaUrl = 'images/marker-icon-2x.png';
        let iconUser = L.icon({
            iconRetinaUrl,
            iconUrl,
            shadowUrl,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize: [41, 41]
        });
        this.userMarker = L.marker([position.coords.latitude, position.coords.longitude]);
        this.userMarker.setIcon(iconUser).addTo(this.map);
        this.map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude), 20);

        navigator.geolocation.watchPosition(this.trackUser.bind(this), this.errorOnPosition.bind(this), {
            enableHighAccuracy: true,
            timeout: 3000,
            maximumAge: 0,
        });
    }

    noUserLocation(positionError) {
        console.warn(`ERROR (${positionError.code}): ${positionError.message}`);
        const valierePosition = [43.5495051, 2.7590491];
        this.map.setView(valierePosition, 20);
    }

    trackUser(position) {
        console.log("User position updated");
        this.userMarker.setLatLng([position.coords.latitude, position.coords.longitude]);
        // this.map.panTo([position.coords.latitude, position.coords.longitude]);
    }

    errorOnPosition(positionError) {
        console.warn(`ERROR (${positionError.code}): ${positionError.message}`);
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
