<?php
namespace Xpressengine\Plugins\Popup\Controllers;

use App\Http\Controllers\Controller;
use XePresenter;
use Xpressengine\Http\Request;
use Xpressengine\Plugins\Popup\Models\PopupItem;
use Carbon\Carbon;
use Xpressengine\Plugins\Popup\Handler;

class UserController extends Controller
{
    public function popup(Request $request, Handler $handler)
    {
        $id = $request->get('id');
        $item = $handler->get($id);

        XePresenter::htmlRenderPRenderPopopup();
        return XePresenter::make('xe_popup::views.user.popup', [
            'item' => $item,
        ]);
    }
}
