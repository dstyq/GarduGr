@extends('layouts.app')

@section('style')
<!-- Load Leaflet from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="https://www.domoritz.de/leaflet-locatecontrol/dist/L.Control.Locate.min.css" />

<!-- Load Esri Leaflet from CDN -->
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<link rel="stylesheet" href="https://www.domoritz.de/leaflet-locatecontrol/dist/L.Control.Locate.mapbox.min.css" />

<link rel="stylesheet" href="{{ asset('css/maps.css') }}">

<style>
</style>
@endsection

@section('content')
<section class="content mt-2 mr-0 ml-0 pl-0 pr-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @foreach ($access as $item)
                        <a onclick="run('{{ $item->tSnapLocation }}')" href="#">awda</a>
                                <div><img src="file:///{{ str_replace("\\",'/',$item->tSnapLocation) }}"  width="150px" height="200px">
                                    <small>file:///{{ str_replace("\\",'/',$item->tSnapLocation) }}</small>
                                    <a href="file:///{{ str_replace("\\",'/',$item->tSnapLocation) }}" target="_blank">test</a>
                                    {{-- <img src="/file:{{ str_replace("\\",'/',$item->tSnapLocation) }}" height="100" width="200" alt=""> --}}
                                </div>
                        @endforeach
                    </div>
                </div>
            </div> 
        </div>
    </div>
</section>
@endsection

@section('script')
<!-- Load Leaflet from CDN -->
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.73.0/src/L.Control.Locate.min.js"></script>

<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js" integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script> 
function run(ursl){

var URL = ursl;

window.open(URL, null);

}
run();
    $(document).ready(function() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                localCoord = position.coords;
                lat = localCoord.latitude;
                long = localCoord.longitude;

                // Map Satellite
                const sattelite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3']
                });

                // Map Streets
                const streets = L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxNativeZoom:19,
                    maxZoom: 22,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                });

                // Map Topography
                const topography = L.tileLayer('//server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 22,
                    maxNativeZoom: 18,
                });

                // Map Grayscale
                const grayscale = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://cartodb.com/attributions">CartoDB</a>',
                    subdomains: 'abcd',
                    minZoom: 0,
                    maxZoom: 22,
                    maxNativeZoom: 18,
                });

                const map = L.map('map', {
                    center: [-1.695754, 120.409821],
                    zoom: 5,
                    zoomControl: false,
                    fullscreenControl: true,
                    layers: [topography, sattelite, grayscale, streets]
                });

                const basemaps = {
                    "<div class='layers-control-img'><img src='{{ asset('img/topography.png') }}'></div> Topography": topography,
                    "<div class='layers-control-img'><img src='{{ asset('img/satellite.png') }}'></div> Sattelite": sattelite,
                    "<div class='layers-control-img'><img src='{{ asset('img/grayscale.png') }}'></div> Grayscale": grayscale,
                    "<div class='layers-control-img'><img src='{{ asset('img/street.png') }}'></div> Streets": streets,
                };

                L.control.layers(basemaps).addTo(map);

                // add marker
                $.getJSON('api/access-door', data => {
                    $.each(data.data, (index, element) => {
                        const icon = L.icon({
                            iconUrl: `img/access.png`,

                            iconSize:     [40, 40], // size of the icon
                            iconAnchor:   [15, 33], // point of the icon which will correspond to marker's location
                            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                        });

                        const html = `
                            <div class="card card-bs card-primary br-20 mw-200" id="cctv${element.id}">
                                <div class="card-header text-center">
                                    <h6>${element.name}</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-md mt-0 mb-0"><b>Status:</b>
                                        <span class="badge badge-pill badge-success">&nbsp;</span> Online
                                    </p>
                                    <p class="text-md mt-0 mb-0"><b>Description:</b>
                                        ${ element.description ?? '' }
                                    </p>
                                    <p class="text-md mt-0 mb-0"><b>Address:</b>
                                        ${ element.address ?? '' }
                                    </p>
                                    <div class="text-center mt-2">
                                        <a href="/access-door/${ element.id }/edit" target="blank" class="d-inline-block mx-auto btn btn-warning text-light">Edit</a>
                                        <a href="#" target="blank" class="d-inline-block mx-auto btn btn-secondary text-light" onClick="openNew('${ element.link }')">Monitoring View</a>
                                    </div>
                                </div>
                            </div>
                        `;

                        if (element.latitude != "" && element.longitude != "") {
                            L.marker([parseFloat(element.latitude), parseFloat(element.longitude)], {icon: icon}).on('click', function() { 
                            L.popup()
                                .setLatLng([parseFloat(element.latitude), parseFloat(element.longitude)])
                                .setContent(html)
                                .openOn(map);
                            }).addTo(map); 
                        }
                    })
                })

                lc = L.control.locate({
                    strings: {
                        title: "Show my location!"
                    },
                    initialZoomLevel: 13
                }).addTo(map);
            });
        }
    });

    function openNew(url) {
      var url = url
      newwindow = window.open(url, '_blank');
      if (window.focus) {
        newwindow.focus()
      }
      return false;
    }
</script>
@endsection