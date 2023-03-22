<!DOCTYPE html>
<html lang="en">

<head>
    <title>Get Latitude and Longitude</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
</head>
<style>
    #OpenStreetMap {
        width: 100%;
        height: 30vh;
    }
</style>

<body>

    <div class="jumbotron text-center">
        <h1>Get Latitude and Longitude from Address</h1>
        <p> using Google Maps and OpenStreetMap!</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4 auto">
                <form action="api/getlatlong.php" method="POST" id="ajax-form">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="mapType" id="GoogleMapRadio"
                            value="GoogleMap">
                        <label class="form-check-label" for="GoogleMapRadio">
                            Google Map
                        </label>
                        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="form-check-input" type="radio" name="mapType" id="OpenStreetMapRadio"
                            value="OpenStreetMap" checked>
                        <label class="form-check-label" for="OpenStreetMapRadio">
                            OpenStreet Map
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            aria-describedby="addressHelp" placeholder="Enter Address">
                        <small id="addressHelp" class="form-text text-muted">Please Enter the address for get the
                            Latitude and Longitude </small>
                    </div>
                    <input type="hidden" name="getlatlong" value="1" />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <p id="show_message" style="display: none"> </p>
                <span id="error" style="display: none" class="text-danger"></span>
            </div>
            <p> Latitude: <span id="latData"></span> Longitude: <span id="lngData"></span></p>
            <div class="row">
                <div id="GoogleMap"></div>
            </div>
            <div class="row">

                <div id="OpenStreetMap"></div>

            </div>


        </div>
    </div>

</body>
<script type="text/javascript">
    $(document).ready(function($) {
        // hide messages 
        $("#error").hide();
        $("#show_message").hide();
        // on submit...
        $('#ajax-form').submit(function(e) {
            e.preventDefault();
            $("#error").hide();
            //name required
            var address = $("input#address").val();
            var mapType = $('input[name="mapType"]:checked').val();
            if (address == "") {
                $("#error").fadeIn().text("address required.");
                $("input#address").focus();
                return false;
            }

            // ajax
            $.ajax({
                type: "POST",
                url: "api/getlatlong.php",
                data: $(this).serialize(), // get all form field value in serialize form
                success: function(response) {
                    let geoData = JSON.parse(response);
                    $("#latData").text(geoData.lat);
                    $("#lngData").text(geoData.lng);
                    let mapOptions = {
                        center: [geoData.lat, geoData.lng],
                        zoom: 10
                    }
                    
                    let MapObj = new L.map(mapType, mapOptions);

                    let layer = new L.TileLayer(
                        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
                    MapObj.addLayer(layer);

                    let marker = new L.Marker([geoData.lat, geoData.lng]);
                    marker.addTo(MapObj);


                    $("#show_message").fadeIn();
                    //$("#ajax-form").fadeOut();
                }
            });
        });
        return false;
    });
</script>

</html>
