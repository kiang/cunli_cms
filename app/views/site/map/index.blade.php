@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<form class="form-inline" style="padding: 8px;" class="col-md-4">
    <div class="row">
        <div class="form-group col-lg-2">
            <select class="form-control select-county" name="county">
                <option value="0">縣市</option>
            </select>
        </div>
        <div class="form-group col-lg-2">
            <select class="form-control select-town" name="town">
                <option value="0">鄉鎮市區</option>
            </select>
        </div>
        <div class="form-group col-lg-2">
            <select class="form-control select-cunli" name="cunli">
                <option value="0">村里</option>
            </select>
        </div>
        <div class="col-lg-4"><a class="btn btn-primary">目前有 x 人登記參選</a> <a class="btn btn-primary btn-signup iframe" hrebf="#">立刻登記一個</a></div>
    </div>
</form>
<div id="map_canvas" style="width:100%; height:600px"></div>
@stop
@section('page-script')
<script>
    $(function() {
        var mapOptions = {
            center: new google.maps.LatLng(21.896710512476858, 119.3151574766245),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);

        var listInfo = [];
        var overlays = [];
        var lastPolygon = {};
        var currentCunliId = '';
        var signupBaseUrl = "{{{ URL::to('candidates/new') }}}";

        $.getJSON('json/list.json', function(data) {
            listInfo = data;
            var countySelect = $('select.select-county');
            countySelect.html('');

            $.each(listInfo.counties, function(k, v) {
                $('<option>').val(k).html(v).appendTo(countySelect);
            });

            countySelect.change(function() {
                var selectedCountyId = $(this).val();
                var townSelect = $('select.select-town');
                townSelect.html('');
                $.each(listInfo.county2towns[selectedCountyId], function(k, v) {
                    $('<option>').val(v).html(listInfo.towns[v]).appendTo(townSelect);
                });
                townSelect.trigger('change');
            });

            countySelect.trigger('change');
        });

        $('select.select-cunli').change(function() {
            var vid = $(this).val();
            google.maps.event.trigger(overlays[vid], 'click');
            currentCunliId = vid;
            $('a.btn-signup').attr('href', signupBaseUrl + '/' + currentCunliId);
        });

        $('select.select-town').change(function() {
            var selectedCountyId = $('select.select-county').val();
            var selectedTownId = $(this).val();
            if (selectedTownId !== '' && selectedTownId != '0') {
                $.getJSON('json/' + selectedCountyId + '_' + selectedTownId + '.json', function(data) {
                    var cunli_geojson = topojson.feature(data, data.objects.layer1).features;
                    var bounds = new google.maps.LatLngBounds;
                    var cunliSelect = $('select.select-cunli');
                    cunliSelect.html('');

                    var style = {
                        strokeColor: "#0000FF",
                        strokeWeight: 1,
                        strokeOpacity: 0.45,
                        fillOpacity: 0.1,
                        fillColor: '#333300'
                    };

                    $.each(overlays, function(k, v) {
                        v.setMap(null);
                    });
                    overlays = [];

                    var pushPolygon = function(cunliPoint, k) {
                        $('<option>').val(cunli_geojson[k].properties.V_ID).html(cunli_geojson[k].properties.VILLAGE).appendTo(cunliSelect);

                        var gCenter = new google.maps.LatLng(cunli_geojson[k].properties.Y, cunli_geojson[k].properties.X);

                        var myOptions = {
                            content: cunli_geojson[k].properties.TV_ALL
                            , boxStyle: {
                                border: "1px solid black"
                                , textAlign: "center"
                                , fontSize: "8pt"
                                , width: "80px"
                            }
                            , boxClass: 'labelCunli'
                            , disableAutoPan: true
                            , pixelOffset: new google.maps.Size(-25, 0)
                            , position: gCenter
                            , closeBoxURL: ""
                            , isHidden: false
                            , pane: "mapPane"
                            , enableEventPropagation: true
                        };

                        var ibLabel = new InfoBox(myOptions);
                        ibLabel.open(map);
                        overlays.push(ibLabel);
                        cunliPoint.addListener('click', function() {
                            if (typeof (lastPolygon.setOptions) === 'function') {
                                lastPolygon.setOptions({
                                    fillColor: '#333300',
                                    fillOpacity: 0.1
                                });
                            }

                            lastPolygon = this;
                            var latLngs = this.latLngs.getArray();
                            var newBounds = new google.maps.LatLngBounds;
                            lastPolygon.setOptions({
                                fillColor: '#FFFF00',
                                fillOpacity: 0.6
                            });

                            cunliSelect.val(this.geojsonProperties.V_ID);

                            latLngs[0].forEach(function(p) {
                                newBounds.extend(p);
                            });
                            map.setZoom(15);
                            map.panTo(newBounds.getCenter());
                        });

                        bounds.extend(gCenter);
                        cunliPoint.setMap(map);
                        overlays[cunli_geojson[k].properties.V_ID] = cunliPoint;
                        
                        cunliSelect.trigger('change');
                    }

                    $.each(cunli_geojson, function(k, v) {
                        var cunli = new GeoJSON(cunli_geojson[k], style);
                        if (typeof cunli.setMap === 'function') {
                            pushPolygon(cunli, k);
                        } else if (null !== cunli_geojson[k].geometry) {
                            //MultiPolygon
                            for (mk in cunli) {
                                pushPolygon(cunli[mk], k);
                            }
                        }
                    });
                    map.setCenter(bounds.getCenter());
                });
            }
        });
        
        $('a.iframe').colorbox({iframe: true, width: "80%", height: "80%"});

    });
</script>
@stop