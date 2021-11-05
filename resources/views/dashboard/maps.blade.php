@extends('layouts.app')

@section('style')
<!-- Load Leaflet from CDN -->
<link rel="stylesheet" href="{{ asset('css/leaflet/leaflet.css') }}" />

<!-- Load Esri Leaflet from CDN -->
<link href='{{ asset('css/leaflet/leaflet-fullscreen.css') }}' rel='stylesheet' />

{{-- Leaflet legend --}}
<link rel="stylesheet" href="{{ asset('css/leaflet-control/leaflet.legend.css') }}" />

<link rel="stylesheet" href="{{ asset('css/maps.css') }}">
@endsection

@section('content')
<section class="content mt-2 mr-0 ml-0 pl-0 pr-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="map">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('script')
<!-- Load Leaflet from CDN -->
<script src="{{ asset('js/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('js/leaflet/leaflet-control-locate.js') }}"></script>

<!-- Load Esri Leaflet from CDN -->
<script src="{{ asset('js/leaflet/esri-leaflet.js') }}"></script>
<script src='{{ asset('js/leaflet/leaflet-fullscreen.js') }}'></script>

{{-- Leaflet Legend --}}
<script type="text/javascript" src="{{ asset('js/leaflet-control/leaflet.legend.js') }}"></script>

{{-- Socket IO --}}
<script src="{{ asset('js/socket/socket.js') }}">
</script>

<script>
    $('body').addClass('sidebar-collapse')
    const officon = L.icon({
        iconUrl: `img/location-off.png`,

        iconSize:     [40, 40], // size of the icon
        iconAnchor:   [19, 39], // point of the icon which will correspond to marker's location
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    const onicon = L.icon({
        iconUrl: `img/location-on.png`,

        iconSize:     [40, 40], // size of the icon
        iconAnchor:   [19, 39], // point of the icon which will correspond to marker's location
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    var markers = []
    var parentLocation = []
    var subLocation = []
    var parentStatus = []
    var popups = []
    var map;

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

                // Setting basemaps
                const basemaps = {
                    "<div class='layers-control-img'><img src='{{ asset('img/topography.png') }}'></div> Topography": topography,
                    "<div class='layers-control-img'><img src='{{ asset('img/satellite.png') }}'></div> Sattelite": sattelite,
                    "<div class='layers-control-img'><img src='{{ asset('img/grayscale.png') }}'></div> Grayscale": grayscale,
                    "<div class='layers-control-img'><img src='{{ asset('img/street.png') }}'></div> Streets": streets,
                };

                // Configure map
                map = L.map('map', {
                    center: [-1.695754, 120.409821],
                    zoom: 5,
                    zoomControl: false,
                    fullscreenControl: false,
                    layers: [topography, sattelite, grayscale, streets]
                });

                // Start Configuration Control

                // Add change layer control
                L.control.layers(basemaps).addTo(map);

                // Add legend control
                const legend = L.control.Legend({
                    position: "bottomright",
                    collapsed: false,
                    title: 'Information',
                    symbolWidth: 26,
                    opacity: 0.8,
                    column: 1,
                    legends: [{
                        label: "NVR-ACCESS ON",
                        type: "image",
                        url: "img/location-on.png",
                    }, {
                        label: "NVR-ACCESS OFF",
                        type: "image",
                        url: "img/location-off.png"
                    }]
                })
                .addTo(map);

                // Add fullscreen control
                L.control.fullscreen({
                    position: 'topright'
                }).addTo(map);              

                // Get Current Location control
                L.control.locate({
                    strings: {
                        title: "Show my location!"
                    },
                    position: 'topright',
                    initialZoomLevel: 13
                }).addTo(map);

                // Add Zoom control
                L.control.zoom({
                    position: 'topright'
                }).addTo(map);

                // Start Search Control
                L.Control.MyControl = L.Control.extend({
                    onAdd: function(map) {
                        let parentLocation = []
                        $.ajax({
                            type: 'GET',
                            url: "/api/parent-location",
                            dataType: 'json',
                            async: false,
                            success: function (data) {
                                parentLocation = data.data
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });

                        var el = L.DomUtil.create('div', 'leaflet-bar my-control search-control');

                        el.innerHTML = `<div onclick="switchMenu('expand')" id="test1"><img src="{{ asset('img/map.png') }}" width="30px" class="image img" ></div>`;
                        el.innerHTML += `<div class="d-none p-2" id="test2">
                            <select class="tx-30 select-search" onchange="changeSubLocation(this.value);" id="selectLocation">
                                <option value="none">None</option>   
                                ${Object.keys(parentLocation).map(key => (
                                    `<option value="${parentLocation[key].id}">${parentLocation[key].name}</option>`
                                )).join('')}  
                            </select>
                            <img class="ml-2 img-close" onclick="switchMenu('collapse')" src="https://img.icons8.com/material-outlined/24/000000/multiply--v1.png"/>
                            <hr>
                            <ul id="subLocationList">
                            </ul>
                        </div>`;

                        return el;
                    },

                    onRemove: function(map) {
                        // Nothing to do here
                    }
                });

                L.control.myControl = function(opts) {
                    return new L.Control.MyControl(opts);
                }

                L.control.myControl({
                    position: 'topleft'
                }).addTo(map);
                // End Search Control

                // Start Info Control
                L.Control.Info = L.Control.extend({
                    onAdd: function(map) {
                        var el = L.DomUtil.create('div', 'leaflet-bar my-control info-control');
                        el.innerHTML += `<i class="fas fa-map-marked-alt"></i> <span id="countParentLocation">0</span> Region | <i class="fas fa-building"></i> <span id="countSubLocation">0</span> Office`;

                        return el;
                    },

                    onRemove: function(map) {
                        // Nothing to do here
                    }
                });

                L.control.Info = function(opts) {
                    return new L.Control.Info(opts);
                }

                L.control.Info({
                    position: 'bottomleft'
                }).addTo(map);
                // End Info Control

                // End Configure Control

                 // get location
                 $.getJSON('api/cctv', data => {
                    // Foreach Parent location
                    $.each(data.data, (index, element) => {
                        // Configure parent location

                        // if latitude and longitude exist
                        if (element.latitude != "" && element.longitude != "") {
                            // Add marker with default icon off
                            markers[element.id] = L.marker([parseFloat(element.latitude), parseFloat(element.longitude)], {icon: onicon}).addTo(map);

                            // Add tooltip
                            markers[element.id].bindTooltip(element.name, {
                                direction: 'bottom',
                            }).openTooltip();

                            $(markers[element.id]._icon).attr('id', `marker${element.id}`);
                            $(markers[element.id]._icon).addClass('cctv');
                            $(markers[element.id]._icon).addClass('parent-cctv');

                            let parentLocationCount = $('#countParentLocation').text()
                            $('#countParentLocation').text(parseInt(parentLocationCount) + 1)

                            // Zoom marker parent location on click
                            markers[element.id].on('click', function(e){
                                $(markers[element.id]._icon).addClass('d-none');
                                $('.cctv').addClass('d-none')
                                $(`.child-location-${element.id}`).removeClass('d-none')
                                $("#selectLocation").val(element.id).change()
                                map.setView(e.latlng, 12);
                            });
                        }

                        // foreach sublocation
                        $.each(element.children, (i, e) => {
                            // Configure Sublocation
                            if (e.cctv.length > 0) {
                                let cctv = e.cctv[0]

                                // Pop Up sub location
                                const html = `
                                    <div class="card card-bs card-danger mw-200">
                                        <div class="card-header text-center" style="background: rgb(41,41,41) !important;background: linear-gradient(152deg, rgba(41,41,41,1) 17%, rgba(255,0,0,1) 100%) !important; padding: 10px 5px 3px 5px !important; margin: 0 !important">
                                            <h6>${cctv.name}</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-md mt-0 mb-0"><b>Status:</b>
                                                <span class="badge badge-pill" id="badge${e.id}">&nbsp;</span> <span id="text${e.id}"></span>
                                            </p>
                                            <p class="text-md mt-0 mb-0"><b>Description:</b>
                                                ${ cctv.description ?? '' }
                                            </p>
                                            <p class="text-md mt-0 mb-0"><b>Address:</b>
                                                ${ cctv.address ?? '' }
                                            </p>
                                            <div class="text-center mt-2">
                                                <a href="/cctv/${ cctv.id }/edit" target="blank" class="d-inline-block mx-auto btn btn-warning text-light">Edit</a>
                                                <a href="#" target="blank" class="d-inline-block mx-auto btn btn-secondary text-light" onClick="openNew('${ cctv.link }')">Monitoring View</a>
                                            </div>
                                        </div>
                                    </div>
                                `;

                                // if latitude and longitude exist
                                if (e.latitude != "" && e.longitude != "") {
                                    subLocation.push(e.id)
                                    let subLocationCount = $('#countSubLocation').text()
                                    $('#countSubLocation').text(parseInt(subLocationCount) + 1)
                                    // add marker with default icon off and when On click show pop up
                                    popups[e.id] = L.popup()
                                            .setLatLng([parseFloat(e.latitude), parseFloat(e.longitude)])
                                            .setContent(html);

                                    markers[e.id] = L.marker([parseFloat(e.latitude), parseFloat(e.longitude)], {icon: officon}).on('click', function() {                                             
                                        popups[e.id].openOn(map);
                                    }).addTo(map);

                                    // Add tooltip
                                    markers[e.id].bindTooltip(e.name, {
                                        direction: 'bottom',
                                    });

                                    $(markers[e.id]._icon).attr('id', `marker${e.id}`);
                                    $(markers[e.id]._icon).addClass(`child-location-${element.id}`);
                                    $(markers[element.id]._icon).addClass('child-cctv');
                                    $(markers[e.id]._icon).addClass('cctv');
                                    $(markers[e.id]._icon).addClass('d-none');

                                    // Zoom marker sublocation on click
                                    markers[e.id].on('click', function(z){
                                        map.setView([z.latlng.lat, z.latlng.lng], 16);
                                    });
                                }
                            }
                        })
                    })
                })
            });
        }
    });

    function changeSubLocation(sel = "none") {
        $.ajax({
            type: 'GET',
            url: "/api/sub-location-list/" + sel,
            dataType: 'json',
            success: function (data) {
                $('#subLocationList').empty()
                data.data.map((location) => {
                    $("#subLocationList").append(`<li><a href="#${location.id}" onclick="focusSubLocation(${location.id})">${location.cctv[0].name}</a></li>`);
                })

                if (sel == 'none') {
                    $('.child-cctv').addClass('d-none')
                    $('.parent-cctv').removeClass('d-none')

                    map.setView([-1.695754, 120.409821], 5);
                } else {
                    $(markers[sel]._icon).addClass('d-none');
                    $('.cctv').addClass('d-none')
                    $(`.child-location-${sel}`).removeClass('d-none')

                    map.setView([data.location.latitude, data.location.longitude], 12);
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function focusSubLocation(id) {
        $.ajax({
            type: 'GET',
            url: "/api/location/" + id,
            dataType: 'json',
            success: function (data) {
                map.setView([data.data.latitude, data.data.longitude], 16);
                popups[id].openOn(map);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    function switchMenu(status) {
        if (status == "expand") {
            $('#test1').addClass('d-none')
            $('#test2').removeClass('d-none')
        } else {
            $('#test1').removeClass('d-none')
            $('#test2').addClass('d-none')
        }
    }

    const socket = io('http://localhost:1010');

    socket.on('realtimeStatus', function(data) {
        let { id, status, role, parent_id} = data
        console.log(data);
        changeStatus(id, status, role, parent_id)
    });

    function changeStatus(id, status, role, parent_id) {
        if (status) {
            $(`#badge${id}`).removeClass('badge-danger');
            $(`#badge${id}`).addClass('badge-success');
            $(`#text${id}`).text('Online');
            if (markers[id] != undefined && !$(`#marker${id}`).hasClass('d-none')) {
                markers[id].setIcon(onicon)
            }
        } else {
            $(`#badge${id}`).removeClass('badge-success');
            $(`#badge${id}`).addClass('badge-danger');
            $(`#text${id}`).text('Offline');
            if (markers[id] != undefined && !$(`#marker${id}`).hasClass('d-none')) {
                markers[id].setIcon(officon)
            }
        }

        if (markers[id] != undefined) {
            $(markers[id]._icon).addClass('cctv');
            if (role == "parent") {
                $(markers[id]._icon).addClass('parent-cctv');
            } else {
                $(markers[id]._icon).addClass(`child-location-${parent_id}`);
                $(markers[id]._icon).addClass('child-cctv');
            }
        }
    }
    

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