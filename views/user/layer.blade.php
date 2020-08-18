{{--todo 팝업 위치 조정 필요, 레이어 사이즈 조정 필요--}}
<div id="xe_popup_name_{{$item->id}}" class="xe-pop">
    @if ($item->popup_content_type == 1)
        {!! $item->popup_content_html !!}
    @elseif ($item->popup_content_type == 2)
        @if ($item->isImage())
            @if ($item->popup_content_file_path != '')
                <img class="xe-pop-img" src="{{$item->popup_content_file_path}}" alt="">
            @endif
        @else
            @if ($item->popup_content_file_path != '')
                @include($item->popup_content_file_path)
            @endif
        @endif
    @endif

    <div class="pop-close-box">
        <form name="pop_form">
            <div class="pop-check" id="check"> <label for=""> <input type="checkbox" name="chkbox" value="checkbox">{!! $item->inactive_days_message !!} </label> </div>
            <div class="pop-close" id="close" style="margin:auto;"><a class="pop-close-text" href="javascript:closeXePopup('xe_popup_name_{{$item->id}}', {{$item->inactive_days}});">CLOSE</a></div>
        </form>
    </div>
</div>
