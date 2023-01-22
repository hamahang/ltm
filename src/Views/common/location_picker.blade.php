<div id="{{$modal_id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{$modal_title}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="width: 550px">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">موقعیت:</label>
                        <div class="col-sm-10">
                            <input name="{{$input_address}}_name" type="text" class="form-control ltr" id="{{$input_address}}_id"/>
                        </div>
                    </div>
                    <div id="{{$map_area_id}}" style="width: {{$map_area_width}}; height: {{$map_area_height}};"></div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="m-t-small">
                        <label class="p-r-small col-sm-1 control-label">Lat.:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control ltr" id="{{$lat_input_id}}_tmp"/>
                        </div>
                        <label class="p-r-small col-sm-1 control-label">Long.:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control ltr" id="{{$long_input_id}}_tmp"/>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                </div>
                <div class="clearfix">&nbsp;</div>
            </div>
            <script>
                var current_lat = $('#{{$lat_input_id}}').val();
                current_lat = current_lat || 35.70;
                var current_long = $('#{{$long_input_id}}').val();
                current_long = current_long || 51.40;
                $('#{{$map_area_id}}').locationpicker({
                    location: {
                        latitude: current_lat,
                        longitude: current_long
                    },
                    radius: {{$marker_radius}},
                    inputBinding: {
                        latitudeInput: $('#{{$lat_input_id}}_tmp'),
                        longitudeInput: $('#{{$long_input_id}}_tmp'),
                        locationNameInput: $('#{{$input_address}}_id')
                    },
                    enableAutocomplete: true,
                    markerIcon: undefined,
                    markerDraggable: true,
                    markerVisible : true
//                    markerIcon: 'http://www.iconsdb.com/icons/preview/tropical-blue/map-marker-2-xl.png'
                });
                $('#{{$modal_id}}').on('shown.bs.modal', function () {
                    $('#{{$map_area_id}}').locationpicker('autosize');
                });
                $(document).on('click', '#{{$modal_id}}_submit_location', function () {
                    var lat_temp = $('#{{$lat_input_id}}_tmp').val();
                    var long_temp = $('#{{$long_input_id}}_tmp').val();
                    $('#{{$lat_input_id}}').val(lat_temp);
                    $('#{{$long_input_id}}').val(long_temp);
                })
            </script>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="{{$modal_id}}_submit_location">انتخاب و بستن</button>
            </div>
        </div>
    </div>
</div>