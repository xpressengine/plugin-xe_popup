<?php
namespace Xpressengine\Plugins\Popup\Controllers;

use App\Http\Controllers\Controller;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Plugins\Popup\Models\PopupItem;
use Carbon\Carbon;
use Xpressengine\Plugins\Popup\Handler;

class SettingController extends Controller
{
    protected $perPage = 2;

    public function index(Request $request)
    {
        $query = PopupItem::query();

        $current = Carbon::now();
        //기간 검색
        if ($endDate = $request->get('end_date', $current->format('Y-m-d'))) {
            $query = $query->where('created_at', '<=', $endDate . ' 23:59:59');
        }
        if ($startDate = $request->get('start_date', $current->subDay(7)->format('Y-m-d'))) {
            $query = $query->where('created_at', '>=', $startDate . ' 00:00:00');
        }

        if ($userEmail = $request->get('user_email')) {
            $writers = \XeUser::where(
                'email',
                'like',
                '%' . $userEmail . '%'
            )->selectRaw('id')->get();

            $writerIds = [];
            foreach ($writers as $writer) {
                $writerIds[] = $writer['id'];
            }
            $query = $query->whereIn('user_id', $writerIds);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate($this->perPage)->appends($request->except('page'));

        return XePresenter::make('xe_popup::views.setting.index', [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'userEmail' => $userEmail,
        ]);
    }

    public function create(Request $request, Handler $handler)
    {
        $instanceGroup = $handler->getModuleList();
        $instanceItems = [];
        foreach ($instanceGroup as $type => $instances) {
            foreach ($instances as $menuItem) {
                $instanceItems[$menuItem->id] = [
                    'menu_item' => $menuItem,
                ];
            }
        }

        $rules = $handler->getCreateRule();

        return XePresenter::make('xe_popup::views.setting.create', [
            'instanceItems' => $instanceItems,
            'rules' => $rules,
        ]);
    }

    public function add(Request $request, Handler $handler)
    {
        $this->validate($request, $handler->getCreateRule());

        $params = $request->only(['popup_name', 'occur_type', 'occur_url_info', 'popup_open_type', 'popup_content_type', 'popup_content_html',
            'link', 'link_target', 'size_width', 'size_height', 'position_x', 'position_y', 'inactive_days', 'inactive_days_message',
            'status', 'expose_type', 'started_at', 'ended_at', 'started_time_at', 'ended_time_at']);
        if ($request->has('occur_module_info')) {
            $params['occur_module_info'] = json_enc($request->has('occur_module_info'));
        } else {
            $params['occur_module_info'] = '{}';
        }

        if ($request->has('popup_content_file')) {
            $contentFilePath = $handler->uploadContentFile($request->file('popup_content_file'));
            $params['popup_content_file_path'] = $contentFilePath;
        } else {
            $params['popup_content_file_path'] = '';
        }

        $item = $handler->add($params);

        return redirect()->route('xe_popup::setting.edit', ['id' => $item->id]);
    }

    public function edit(Request $request, Handler $handler, $id)
    {
        $item = $handler->get($id);

        $instanceGroup = $handler->getModuleList();
        $instanceItems = [];
        foreach ($instanceGroup as $type => $instances) {
            foreach ($instances as $menuItem) {
                $instanceItems[$menuItem->id] = [
                    'menu_item' => $menuItem,
                ];
            }
        }

        $rules = $handler->getCreateRule();

        return XePresenter::make('xe_popup::views.setting.edit', [
            'item' => $item,
            'instanceItems' => $instanceItems,
            'rules' => $rules,
        ]);
    }

    public function update(Request $request, Handler $handler)
    {
        $id = $request->get('id');

        $this->validate($request, $handler->getCreateRule());

        $item = $handler->get($id);

        $params = $request->only(['popup_name', 'occur_type', 'occur_url_info', 'popup_open_type', 'popup_content_type', 'popup_content_html',
            'link', 'link_target', 'size_width', 'size_height', 'position_x', 'position_y', 'inactive_days', 'inactive_days_message',
            'status', 'expose_type', 'started_at', 'ended_at', 'started_time_at', 'ended_time_at']);
        if ($request->has('occur_module_info')) {
            $params['occur_module_info'] = json_enc($request->get('occur_module_info'));
        } else {
            $params['occur_module_info'] = '{}';
        }

        if ($request->has('popup_content_file')) {
            $contentFilePath = $handler->uploadContentFile($request->file('popup_content_file'));
            $params['popup_content_file_path'] = $contentFilePath;
        } else {
            $params['popup_content_file_path'] = '';
        }

        $item = $handler->put($item->id, $params);

        return redirect()->route('xe_popup::setting.edit', array_merge($request->only(['page']), ['id' => $item->id]));
    }

    public function delete(Request $request, Handler $handler)
    {
        $id = $request->get('id');
        $item = $handler->get($id);
        $handler->destroy($item->id);

        return redirect()->route('xe_popup::setting.index', array_merge($request->only(['page'])));
    }
}
