@section('page_title')
    <h2>{!!xe_trans('xe_popup::popup')!!}</h2>
@stop

{{ app('xe.frontend')->js('plugins/xe_popup/assets/vendor/datetimepicker/jquery.datetimepicker.full.js')->load() }}
{{--{{ app('xe.frontend')->js('plugins/xe_popup/assets/vendor/datetimepicker/jquery.datetimepicker.min.js')->load() }}--}}
{{ app('xe.frontend')->css('plugins/xe_popup/assets/vendor/datetimepicker/jquery.datetimepicker.min.css')->load() }}

{{ XeFrontend::rule('rule1', $rules) }}

<div class="container-fluid container-fluid--part xe-popup">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                <form method="post" action="{{route('xe_popup::setting.update', Request::all())}}" enctype="multipart/form-data" data-rule="rule1" data-rule-alert-type="toast" >
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3>{!!xe_trans('xe_popup::popupSetup')!!}</h3>
                            <p class="help-block"></p>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::popupName')!!}</label>
                                        <input class="form-control" name="popup_name" value="{{Request::old('popup_name', $item->popup_name)}}" data-valid-name="{{ xe_trans('xe_popup::popupName') }}">
                                        <p class="help-block">{!!xe_trans('xe_popup::popupNameDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::occurType')!!}</label>
                                        <select class="form-control" name="occur_type" data-selected-value="{{Request::old('occur_type', $item->occur_type)}}">
                                            <option value="1" >{!!xe_trans('xe_popup::menuModule')!!}</option>
                                            <option value="2" >{!!xe_trans('xe_popup::url')!!}</option>
                                        </select>
                                        <p class="help-block">{!!xe_trans('xe_popup::occurTypeDescription')!!}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::occurModuleInfo')!!}</label>
                                        <div class="checkbox-group" data-checkbox-value="{{json_enc(Request::old('occur_module_info', json_dec($item->occur_module_info)))}}">
                                            <input type="checkbox" name="occur_module_info_checkall" value=""> Check all <br/>
                                            @foreach ($instanceItems as $instanceItem)
                                                <label><input type="checkbox" name="occur_module_info[]" value="{{$instanceItem['menu_item']->id}}"> {!! xe_trans($instanceItem['menu_item']->title) !!}({!! xe_trans($instanceItem['menu_item']->url) !!}) </label> &nbsp;
                                            @endforeach
                                        </div>
                                        <p class="help-block">{!!xe_trans('xe_popup::occurModuleInfoDescription')!!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 form-col" style="display:none;">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::occurUrlInfo')!!}</label>
                                        <input class="form-control" name="occur_url_info" value="{{Request::old('occur_url_info', $item->occur_url_info)}}">
                                        <p class="help-block">{!!xe_trans('xe_popup::occurUrlInfoDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::popupOpenType')!!}</label>
                                        <select class="form-control" name="popup_open_type" data-selected-value="{{Request::old('popup_open_type', $item->popup_open_type)}}">
                                            <option value="1" >{!!xe_trans('xe_popup::layerPopup')!!}</option>
                                            <option value="2" >{!!xe_trans('xe_popup::windowOpen')!!}</option>
                                        </select>
                                        <p class="help-block">{!!xe_trans('xe_popup::popupOpenTypeDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::popupContentType')!!}</label>
                                        <select class="form-control" name="popup_content_type" data-selected-value="{{Request::old('popup_content_type', $item->popup_content_type)}}">
                                            <option value="1" >{!!xe_trans('xe_popup::html')!!}</option>
                                            <option value="2" >{!!xe_trans('xe_popup::file')!!}</option>
                                        </select>
                                        <p class="help-block">{!!xe_trans('xe_popup::popupContentTypeDescription')!!}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 form-col" >
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::popupContentHtml')!!}</label>
                                        <textarea class="form-control" name="popup_content_html">{{Request::old('popup_content_html', $item->popup_content_html)}}</textarea>

                                        <p class="help-block">{!!xe_trans('xe_popup::popupContentHtmlDescription')!!}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 form-col" style="display:none;">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::popupContentFile')!!}</label>

                                        {!! uio('formFile', [
                                        'name' => 'popup_content_file',
                                        'value' => $item->popup_content_file_path,
                                        //'width' => 80,
                                        //'height' => 80,
                                        'types' => ['html','jpg', 'jpeg', 'gif', 'png'],
                                        'fileuploadOptions' => [ 'maxFileSize' => 10000000 ]
                                        ]) !!}
                                        @if ($item->popup_content_file_path != '')
                                            {{$item->popup_content_file_path}}
                                            @if ($item->isImage())
                                                <img src="{{$item->popup_content_file_path}}" style="max-width:100px; width:100%;">
                                            @endif
                                        @endif

                                        <p class="help-block">{!!xe_trans('xe_popup::popupContentFileDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::link')!!}</label>
                                        <input class="form-control" name="link" value="{{Request::old('link', $item->link)}}" data-valid-name="{{ xe_trans('xe_popup::link') }}">
                                        <p class="help-block">{!!xe_trans('xe_popup::linkDescription')!!}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::linkTarget')!!}</label>
                                        <input class="form-control" name="link_target" value="{{Request::old('link_target', $item->link_target)}}">
                                        <p class="help-block">{!!xe_trans('xe_popup::linkTargetDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">

                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::size')!!}</label>

                                        <!-- see https://getbootstrap.com/docs/4.5/components/input-group/#basic-example -->
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::width')!!}</span>
                                            </div>
                                            <input class="form-control" name="size_width" value="{{Request::old('size_width', $item->size_width)}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">px</span>
                                            </div>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::height')!!}</span>
                                            </div>
                                            <input class="form-control" name="size_height" value="{{Request::old('size_height', $item->size_height)}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">px</span>
                                            </div>
                                        </div>

                                        <p class="help-block">{!!xe_trans('xe_popup::sizeDescription')!!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::position')!!}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::positionX')!!}</span>
                                            </div>
                                            <input class="form-control" name="position_x" value="{{Request::old('position_x', $item->position_x)}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">px</span>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::positionY')!!}</span>
                                            </div>
                                            <input class="form-control" name="position_y" value="{{Request::old('position_y', $item->position_y)}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">px</span>
                                            </div>
                                        </div>

                                        <p class="help-block">{!!xe_trans('xe_popup::positionDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::inactiveDays')!!}</label>
                                        <input class="form-control" name="inactive_days" value="{{Request::old('inactive_days', $item->inactive_days)}}">
                                        <p class="help-block">{!!xe_trans('xe_popup::inactiveDaysDescription')!!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::inactiveDaysMessage')!!}</label>
                                        <input class="form-control" name="inactive_days_message" value="{{Request::old('inactive_days_message', $item->inactive_days_message)}}">
                                        <p class="help-block">{!!xe_trans('xe_popup::inactiveDaysMessageDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::status')!!}</label>
                                        <select class="form-control" name="status" data-selected-value="{{Request::old('status', $item->status)}}">
                                            <option value="1" >{!!xe_trans('xe::use')!!}</option>
                                            <option value="0" >{!!xe_trans('xe::disuse')!!}</option>
                                        </select>
                                        <p class="help-block">{!!xe_trans('xe_popup::statusDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-col">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::exposeType')!!}</label>
                                        <select class="form-control" name="expose_type" data-selected-value="{{Request::old('expose_type', $item->expose_type)}}">
                                            <option value="0" >{!!xe_trans('xe::disuse')!!}</option>
                                            <option value="1" >{!!xe_trans('xe_popup::period')!!}</option>
                                            <option value="2" >{!!xe_trans('xe_popup::time')!!}</option>
                                        </select>
                                        <p class="help-block">{!!xe_trans('xe_popup::exposeTypeDescription')!!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 form-col" style="display:none;">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::exposePeriod')!!}</label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::start')!!}</span>
                                            </div>
                                            <input type="text" id="startDatePicker" name="started_at" class="form-control datetimepicker-input" value="{{Request::old('started_at', $item->started_at)}}" data-end-with="endDatePicker" data-date-format="Y-m-d H:i:00" data-timepicker="1" data-default-time="00:00">
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::end')!!}</span>
                                            </div>
                                            <input type="text" id="endDatePicker" name="ended_at" class="form-control datetimepicker-input" value="{{Request::old('ended_at', $item->ended_at)}}" data-start-with="startDatePicker" data-date-format="Y-m-d H:i:00" data-timepicker="1" data-default-time="00:00">
                                        </div>

                                        <p class="help-block">{!!xe_trans('xe_popup::exposePeriodDescription')!!}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 form-col" style="display:none;">
                                    <div class="form-group">
                                        <label class="">{!!xe_trans('xe_popup::exposeTime')!!}</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::start')!!}</span>
                                            </div>
                                            <input type="text" id="endTimePicker" name="started_time_at" class="form-control datetimepicker-input" value="{{Request::old('started_time_at', $item->started_time_at)}}" data-end-with="endTimePicker" data-date-format="H:i:00" data-datepicker="0" data-default-time="00:00">
                                        </div>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{!!xe_trans('xe_popup::end')!!}</span>
                                            </div>
                                            <input type="text" id="endTimePicker" name="ended_time_at" class="form-control datetimepicker-input" value="{{Request::old('ended_time_at', $item->ended_time_at)}}" data-start-with="startTimePicker" data-date-format="H:i:00" data-datepicker="0" data-default-time="23:00">
                                        </div>

                                        <p class="help-block">{!!xe_trans('xe_popup::exposeTimeDescription')!!}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <div class="pull-right">
                                <a class="btn btn-default btn-lg" href="{{route('xe_popup::setting.index', Request::all())}}">{!!xe_trans('xe::list')!!}</a>
                                <button type="button" class="btn btn-danger btn-lg xe-btn btn-delete" data-id="{{$item->id}}">{!! xe_trans('xe::delete') !!}</button>
                                <button type="submit" class="btn btn-primary btn-lg">{!!xe_trans('xe::save')!!}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="form_delete" method="post" action="{{route('xe_popup::setting.delete', Request::all())}}">
    {{ csrf_field() }}
    <input type="hidden" name="id" value=""/>
</form>

<script type="text/javascript">
    $(function () {
        $('[name="occur_type"]').on('change', function () {
            var $o = $(this);
            if ($o.val() == '1') {
                $('[name="occur_module_info_checkall"]').closest('.form-col').show();
                $('[name="occur_url_info"]').closest('.form-col').hide();
            } else if ($o.val() == '2') {
                $('[name="occur_module_info_checkall"]').closest('.form-col').hide();
                $('[name="occur_url_info"]').closest('.form-col').show();
            }
        });

        $('[name="popup_content_type"]').on('change', function () {
            var $o = $(this);
            if ($o.val() == '1') {
                $('[name="popup_content_html"]').closest('.form-col').show();
                $('[name="popup_content_file"]').closest('.form-col').hide();
            } else if ($o.val() == '2') {
                $('[name="popup_content_html"]').closest('.form-col').hide();
                $('[name="popup_content_file"]').closest('.form-col').show();
            }
        });

        $('[name="expose_type"]').on('change', function () {
            var $o = $(this);
            if ($o.val() == '0') {
                $('[name="started_at"]').closest('.form-col').hide();
                $('[name="started_time_at"]').closest('.form-col').hide();
            } else if ($o.val() == '1') {
                $('[name="started_at"]').closest('.form-col').show();
                $('[name="started_time_at"]').closest('.form-col').hide();
            } else if ($o.val() == '2') {
                $('[name="started_at"]').closest('.form-col').show();
                $('[name="started_time_at"]').closest('.form-col').show();
            }
        });

        $('[name="occur_module_info_checkall"]').on('click', function () {
            var $o = $(this),
                checked = $o.prop('checked');
            $('[name="occur_module_info[]"]').each(function () {
                var $o = $(this);
                $o.prop('checked', checked);
            });
        });

        $('.datetimepicker-input').each(function () {
            var $o = $(this);

            $o.datetimepicker({
                format : $o.data('date-format')
                , datepicker : $o.data('datepicker') == '0' ? false : true
                , timepicker : $o.data('timepicker') == '0' ? false: true
                , defaultTime : $o.data('default-time') == undefined ? false: $o.data('default-time')
                , minDateTime : $o.data('min-datetime') == undefined ? false: $o.data('min-datetime')
                , maxDateTime : $o.data('max-datetime') == undefined ? false: $o.data('max-datetime')
            });

            if ($o.data('end-with') != undefined) {
                $o.change(function () {
                    var $eo = $(this);
                    $('#' + $eo.data('end-with')).datetimepicker('setOptions',{minDateTime:$eo.val()});
                });
            }
            if ($o.data('start-with') != undefined) {
                $o.change(function () {
                    var $eo = $(this);
                    $('#' + $eo.data('start-with')).datetimepicker('setOptions',{maxDateTime:$eo.val()});
                });
            }
        });

        // select-box option select
        $('[data-selected-value]').each(function () {
            var $o = $(this),
                selectValue = $o.data('selected-value');
            if (selectValue == undefined) {
                return true;
            }
            // $o.val(selectValue);
            $o.find('option[value="'+selectValue+'"]').prop('selected',true);
            $o.trigger('change');
        });

        // check-box item check
        $('[data-checkbox-value]').each(function () {
            var $o = $(this),
                checkboxValue = $o.data('checkbox-value');

            if (checkboxValue == undefined) {
                return true;    // continue;
            }

            $.each(checkboxValue, function (index, item) {
                if (item == '') {
                    return true;    // continue;
                }
                $o.find('input[value="' + item + '"]').prop('checked', true);
                // $o.find('input[value="' + item + '"]').trigger('click');
            });
        });

        $('.btn-delete').on('click', function () {
            var $o = $(this),
                $frm = $('#form_delete');

            if (confirm('{!! xe_trans('xe::confirmDelete') !!}') == false) {
                return false;
            }
            $frm.find('[name="id"]').val($o.data('id'));
            $frm.submit();
        });
    });
</script>

