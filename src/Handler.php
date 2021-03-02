<?php
namespace Xpressengine\Plugins\Popup;

use Xpressengine\Http\Request;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\ModuleHandler;
use Xpressengine\Plugins\Popup\Models\PopupItem;
use Xpressengine\Presenter\Html\FrontendHandler;
use Illuminate\Routing\Router;
use Carbon\Carbon;

class Handler
{

    protected $uploadPath = 'public/xe_popup/';
    /**
     * html content Html 추가
     */
    public function addHtmlContent(FrontendHandler $frontend, Request $request, Router $router)
    {
        // get popup
        $items = $this->getMatches($request, $router);

        if (count($items)>0) {
            $frontend->js('plugins/xe_popup/assets/js/script.js')->appendTo('body')->load();
            $frontend->css('plugins/xe_popup/assets/css/style.css')->load();
        }
        foreach ($items as $item) {

            if ($item->popup_open_type == '1') {
                // 레이어 팝업
                $content = $this->setLayerPopupContent($item);
                $frontend->html(
                    \Xpressengine\Plugins\Popup\Plugin::getId() . '.popup_' . $item->id
                )->content($content)->load();
            } else if ($item->popup_open_type == '2') {
                // window.open
                $content = $this->setWindowPopupContent($item);
                $frontend->html(
                    \Xpressengine\Plugins\Popup\Plugin::getId() . '.popup_' . $item->id
                )->content($content)->load();
            }
        }
    }

    public function setLayerPopupContent($item)
    {
//        $url = route('xe_popup::user.popup', ['id' => $item->id]);
//        $html = '<script>
//layerXePopup('.json_enc($item).');
//</script>';
        $path = app('config')->get('xe_popup.layer_blade_path');
        if ($path == false) {
            $path = 'xe_popup::views.user.layer';
        }

        $html = view($path, ['item' => $item])->render();
        return $html;
    }

    public function setWindowPopupContent($item)
    {
        $url = route('xe_popup::user.popup', ['id' => $item->id]);
        $html = '<script>
windowXePopup("'.$url.'", '.json_enc($item).');
</script>';
        return $html;
    }

    public function getMatches(Request $request, Router $router)
    {
        $route = $router->current();
        $currentInstanceId = current_instance_id();
        $path = $request->path();
        if ($path == '') {
            $path = '/';
        }
        // path must start with slash
        if ($path != '/') {
            $path = '/'. $path;
        }

        $items = [];
        if ($route && in_array('settings', $route->middleware()) === false) {
            $items = $this->getMatchItems($currentInstanceId, $path);
        } else {
            // 관리자 사이트가 맞을 때
        }

        return $items;
    }

    public function getMatchItems($currentInstanceId, $path)
    {
        $nowDate = Carbon::now();
        // 관리자 사이트가 아닐 때
        $popupItems = PopupItem::where('status', '1')
            ->where(function ($query) use ($currentInstanceId, $path) {
                // 주소 매칭 확인
                $query->where(function ($query) use ($currentInstanceId) {
                    // 모듈 방식 검색
                    $query->where('occur_type', '1')
                        ->where('occur_module_info', 'like', '%"'.$currentInstanceId.'"%');
                })->orWhere(function ($query) use ($path) {
                    // 주소 방식 검색
                    $query->where('occur_type', '2')
                        ->where('occur_url_info', $path);
                });
            })->get();

        $items = [];
        foreach ($popupItems as $popupItem) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $popupItem->started_at);
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $popupItem->ended_at);

            $startTime = Carbon::createFromFormat(
                'Y-m-d H:i:s', $nowDate->format('Y-m-d') . ' ' . $popupItem->started_time_at
            );
            $endTime = Carbon::createFromFormat(
                'Y-m-d H:i:s', $nowDate->format('Y-m-d') . ' ' . $popupItem->ended_time_at
            );

            // 활성화 되는 시간인가?
            if ($popupItem->expose_type == 0) {
                $items[] = $popupItem;
            } else if ($popupItem->expose_type == 1 && $nowDate->between($startDate, $endDate) == true) {
                $items[] = $popupItem;
            } else if (
                $popupItem->expose_type == 2 &&
                $nowDate->between($startDate, $endDate) == true &&
                $nowDate->between($startTime, $endTime) == true
            ) {

            }
        }
        return $items;
    }

    public function getModuleTypeName()
    {
        // name => config instance name
        $names = [
            'board' => 'module/board@board',
            'page' => 'module/page@page',
            'widgetpage' => 'module/widgetpage@widgetpage',
        ];
        return $names;
    }

    public function isSupportModule($moduleType)
    {
        $moduleName =  full_module_id($moduleType);
        $names = $this->getModuleTypeName();
        return in_array($moduleName, $names);
    }

    public function getModuleList()
    {
        $names = $this->getModuleTypeName();

        $moduleGroup = [];
        foreach ($names as $type => $moduleName) {
            $menuItems = MenuItem::where('type', short_module_id($moduleName))->orderBy('ordering')->get();
            $modules = [];
            foreach ($menuItems as $menuItem) {
                $modules[] = $menuItem;
            }
            $moduleGroup[$type] = $modules;
        }

        return $moduleGroup;
    }

    public function getMenuItemByUrl($url)
    {
        $item = MenuItem::where('url', $url)->first();
        return $item;
    }

    public function getMenuItems($ids)
    {
        $items = MenuItem::whereIn('id', $ids)->get();
        return $items;
    }

    public function uploadContentFile($upFile)
    {
        $parts = pathinfo($upFile->getClientOriginalName());

        // check extension
        $extensions = ['html', 'jpg', 'jpeg', 'gif', 'png'];
        if (in_array($parts['extension'], $extensions) == false) {
            throw new \Exception;
        }

        $file = \XeStorage::upload($upFile, $this->uploadPath);

        return str_replace(base_path(), '', app_storage_path($file->getPathname()));
    }

    public function get($id)
    {
        $item = PopupItem::find($id);
        return $item;
    }

    public function add($args)
    {
        if (isset($args['occur_module_info']) == false) {
            $args['occur_module_info'] = '{}';
            // set array to json
        }
        if (isset($args['occur_url_info']) == false) {
            $args['occur_url_info'] = '';
        }
        if (isset($args['popup_content_file_path']) == false) {
            $args['popup_content_file_path'] = '';
        }
        if (isset($args['popup_content_html']) == false) {
            $args['popup_content_html'] = '';
        }
        if (isset($args['link']) == false) {
            $args['link'] = '/';
        }
        if (isset($args['link_target']) == false) {
            $args['link_target'] = '';
        }
        if (isset($args['size_width']) == false) {
            $args['size_width'] = '300';
        }
        if (isset($args['size_height']) == false) {
            $args['size_height'] = '400';
        }
        if (isset($args['position_x']) == false) {
            $args['position_x'] = '100';
        }
        if (isset($args['position_y']) == false) {
            $args['position_y'] = '100';
        }
        if (isset($args['inactive_days']) == false) {
            $args['inactive_days'] = '1';
        }
        if (isset($args['inactive_days_message']) == false) {
            $args['inactive_days_message'] = '오늘 하루 열리지 앟음';
        }
        if (isset($args['started_at']) == false) {
            $args['started_at'] = '';
        }
        if (isset($args['ended_at']) == false) {
            $args['ended_at'] = '';
        }
        if (isset($args['started_time_at']) == false) {
            $args['started_time_at'] = '';
        }
        if (isset($args['ended_time_at']) == false) {
            $args['ended_time_at'] = '';
        }

        $item = new PopupItem;
        $item->fill($args);
        $item->save();

        return $item;
    }


    /**
     * get create rule
     *
     * @return array
     */
    public function getCreateRule()
    {
        $rules = [
            'popup_name' => 'Required',
            'link' => 'Required',
        ];

        return $rules;
    }

    public function put($id, $args)
    {
        $item = $this->get($id);

        // unset from args
        if (isset($args['id'])) {
            unset($args['id']);
        }

        $item->fill($args);

        $item->save();
        return $item;
    }

    public function destroy($id)
    {
        $item = $this->get($id);
        $item->delete();
    }
}
