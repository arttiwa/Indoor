<html>

<head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script type="module" src="./index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="wabcam.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link active">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>
    <div id="map"></div>

    <!-- prettier-ignore -->
    <script>(g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google", l = "importLibrary", q = "__ib__", m = document,
                b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set,
                    e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => {
                        await (a = m.createElement("script"));
                        e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                        e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f;
                        a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                        m.head.append(a)
                    })); d[l] ? console.warn(p + " only loads once. Ignoring:",
                        g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })
            ({ key: "AIzaSyDh1TVElXEFsJW_tLR09FNSwI0BVoZc-yo", v: "weekly" });
    </script>
</body>
<script>
    let map;

    async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");

        map = new Map(document.getElementById("map"), {
            center: { lat: 14.875861119387578, lng: 102.01585113373919 },
            zoom: 18,
        });
    }
    initMap();
</script>
<style>
    /* 
 * Always set the map height explicitly to define the size of the div element
 * that contains the map. 
 */
    #map {
        height: 100%;
    }

    /* 
 * Optional: Makes the sample page fill the window. 
 */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>

</html>