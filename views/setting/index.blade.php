@section('page_title')
    <h2>{{xe_trans('xe_popup::popup')}}</h2>
@stop

<div class="container-fluid container-fluid--part xe-popup">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">
                            </h3>
                        </div>
                        <div class="pull-right">
                            <div class="input-group search-group">
                                <form>
                                    <div>
                                        <div class="search-input-group">
                                            <input type="text" name="popup_name" class="form-control" aria-label="Text input with dropdown button" placeholder="{{xe_trans('xe_popup::popupName')}}" value="{{Request::get('popup_name')}}">
                                            <button class="btn-link">
                                                <i class="xi-search"></i><span class="sr-only">{{xe_trans('xe_popup::popupName')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="input-group search-group">
                                <div class="search-input-group">
                                    <a href="{{route('xe_popup::setting.create')}}" class="btn xe-btn xe-btn-primary">{{xe_trans('xe::create')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{xe_trans('xe_popup::popupName')}}</th>
                                <th scope="col">{{xe_trans('xe_popup::occurType')}}</th>
                                <th scope="col">{{xe_trans('xe_popup::popupOpenType')}}</th>
                                <th scope="col">{{xe_trans('xe_popup::popupContentType')}}</th>
                                <th scope="col">{{xe_trans('xe_popup::link')}}</th>
                                <th scope="col">
                                    {{xe_trans('xe::date')}}
                                </th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><a href="{{route('xe_popup::setting.edit', array_merge(Request::all(), ['id' => $item->id]))}}">{{ $item->popup_name }}</a></td>
                                    <td>{{ $item->occur_type}}</td>
                                    <td>{{ $item->popup_open_type}}</td>
                                    <td>{{ $item->popup_content_type }}</td>
                                    <td>{{ $item->link }}</td>
                                    <td>{{ $item->created_at->format('Y.m.d H:i:s') }}</td>
                                    <td>
                                        <a class="btn btn-default btn-sm xe-btn" href="{{route('xe_popup::setting.edit', array_merge(Request::all(), ['id' => $item->id]))}}">{!! xe_trans('xe::edit') !!}</a>
                                        <button type="button" class="btn btn-danger btn-sm xe-btn btn-delete" data-id="{{$item->id}}">{!! xe_trans('xe::delete') !!}</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($pagination = $items->render())
                        <div class="panel-footer">
                            <div class="pull-left">
                                <nav>
                                    {!! $pagination !!}
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form_delete" method="post" action="{{route('xe_popup::setting.delete', Request::all())}}">
    {{ csrf_field() }}
    <input type="hidden" name="id" value=""/>
</form>

<script>
    $(function () {
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