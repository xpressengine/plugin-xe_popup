<?php
/**
 * Plugin.php
 *
 * PHP version 7
 *
 * @category    Banner
 * @package     Xpressengine\Plugins\Banner
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\Popup;

use App\Facades\XeSkin;
use Illuminate\Database\Schema\Blueprint;
use Route;
use Schema;
use Xpressengine\Plugin\AbstractPlugin;
use Xpressengine\Presenter\Html\HtmlPresenter;

/**
 * Class Plugin
 *
 * @category    Banner
 * @package     Xpressengine\Plugins\Banner
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Plugin extends AbstractPlugin
{
    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행된다.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(Handler::class, function ($app) {
            $proxyClass = app('xe.interception')->proxy(Handler::class, 'XePopup');
            return new $proxyClass($this);
        });
        app()->alias(Handler::class, 'xe.popup');

        $key = static::getId();
        $config = app('config')->get($key, []);
        app('config')->set($key, array_merge(require __DIR__.'/config/config.php', $config));
    }

    /**
     * 이 메소드는 활성화(activate) 된 플러그인이 부트될 때 항상 실행됩니다.
     *
     * @return void
     */
    public function boot()
    {
        // implement code
        $this->route();

        /*
         * 플러그인 실행이 실패하면 종료됨
         * 플러그인 종료를 회피하기 위해서 자체 Exception 처리 방식을 만들어 사용
         *
         * 플러그인 boot 하면서 실패하면 에러 로그에 정보 남기고 프로그램은 계속 실해되도록 설계
         */
        try {
            $this->registerPopupOccurEvent();
        } catch (\Exception $e) {
            \Log::info($e);
        }
    }

    /**
     * 팝업 발생기 등록
     */
    protected function registerPopupOccurEvent()
    {
        intercept(
            sprintf('%s@render', HtmlPresenter::class),
            $this->getId() . '::html_presenter_render',
            function ($func) {

                // html add
                $handler = app(Handler::class);
                $frontendHandler = app('xe.frontend');
                $request = app('request');
                $router = app('router');
                $handler->addHtmlContent($frontendHandler, $request, $router);

                return $func();
            }
        );
    }

    /**
     * route
     *
     * @return void
     */
    protected function route()
    {
        // settings menu 등록
        $menus = [
            'contents.xe_popup' => [
                'title' => 'xe_popup::popup',
                'display' => true,
                'description' => '',
                'ordering' => 30000
            ],
        ];
        foreach ($menus as $id => $menu) {
            app('xe.register')->push('settings/menu', $id, $menu);
        }

        Route::fixed(static::getId(), function () {
            Route::get('popup', [
                'as' => 'xe_popup::user.popup',
                'uses' => 'UserController@popup'
            ]);
        }, ['namespace' => 'Xpressengine\Plugins\Popup\Controllers']);

        Route::settings(
            $this->getId(),
            function () {
                Route::group(
                    ['as' => 'xe_popup::setting.', 'namespace' => 'Xpressengine\Plugins\Popup\Controllers'],
                    function () {
                        Route::get(
                            '/',
                            [
                                'as' => 'index',
                                'uses' => 'SettingController@index',
                                'settings_menu' => 'contents.xe_popup',
                            ]
                        );
                        Route::get(
                            '/create', ['as' => 'create', 'uses' => 'SettingController@create',]
                        );
                        Route::post(
                            '/add', ['as' => 'add', 'uses' => 'SettingController@add',]
                        );
                        Route::get(
                            '/edit/{id}', ['as' => 'edit', 'uses' => 'SettingController@edit',]
                        );
                        Route::post(
                            '/update', ['as' => 'update', 'uses' => 'SettingController@update',]
                        );
                        Route::post(
                            '/delete', ['as' => 'delete', 'uses' => 'SettingController@delete',]
                        );
                    }
                );
            }
        );
    }

    /**
     * 플러그인이 활성화될 때 실행할 코드를 여기에 작성한다.
     *
     * @param string|null $installedVersion 현재 XpressEngine에 설치된 플러그인의 버전정보
     *
     * @return void
     */
    public function activate($installedVersion = null)
    {
        // implement code
        $trans = app('xe.translator');
        $trans->putFromLangDataSource('xe_popup', base_path('plugins/xe_popup/langs/lang.php'));
    }

    /**
     * 플러그인을 설치한다. 플러그인이 설치될 때 실행할 코드를 여기에 작성한다
     *
     * @return void
     */
    public function install()
    {
        if (!Schema::hasTable('popup_items')) {
            Schema::create(
                'popup_items',
                function (Blueprint $table) {
                    $table->engine = "InnoDB";

                    $table->increments('id');
                    $table->string('popup_name', 255);
                    $table->integer('occur_type');  // 발생 위치 설정 방법 (1: 메뉴, 2: 주소)
                    $table->string('occur_module_info', 255);  // 발생 위치 module id
                    $table->string('occur_url_info', 255);  // 발생 위치 url 정보
                    $table->integer('popup_open_type');  // 팝업 타입 (1: 레이어팝업, 2: window.open)
                    $table->string('popup_content_type', 255);  // 팝업 내용 타입 (1: html, 2: 파일)
                    $table->text('popup_content_html', 255);  // 팝업 내용 html (에디터에서 작성)
                    $table->string('popup_content_file_path', 255);  // 팝업 내용 파일 경로, html/이미지 업로드
                    $table->string('link', 1000); // 링크 url
                    $table->string('link_target', 20);  // 링크 target attribute value

                    $table->integer('size_width');
                    $table->integer('size_height');

                    $table->integer('position_x');
                    $table->integer('position_y');

                    $table->float('inactive_days', 5, 2); // 성사용자가 팝업을 열리지 않게 하는 버튼의 쿠키 생성 기준 일 수 설정
                    $table->string('inactive_days_message', 255); // disable_day 버튼에 사용될 메시지 ('ex : 오늘 하루 열리지 않음)

                    //
                    $table->integer('expose_type');
                    $table->timestamp('started_at')->nullable();
                    $table->timestamp('ended_at')->nullable();
                    $table->time('started_time_at')->nullable();
                    $table->time('ended_time_at')->nullable();


                    $table->tinyInteger('status');  // 1: 사용 2: 사용 안함

                    $table->timestamp('created_at');
                    $table->timestamp('updated_at');
                }
            );
        }
    }

    /**
     * 해당 플러그인이 설치된 상태라면 true, 설치되어있지 않다면 false를 반환한다.
     * 이 메소드를 구현하지 않았다면 기본적으로 설치된 상태(true)를 반환한다.
     *
     * @return boolean 플러그인의 설치 유무
     */
    public function checkInstalled()
    {
        return parent::checkInstalled();
    }

    /**
     * 플러그인을 업데이트한다.
     *
     * @return void
     */
    public function update()
    {
    }

    /**
     * 해당 플러그인이 최신 상태로 업데이트가 된 상태라면 true, 업데이트가 필요한 상태라면 false를 반환함.
     * 이 메소드를 구현하지 않았다면 기본적으로 최신업데이트 상태임(true)을 반환함.
     *
     * @return boolean 플러그인의 설치 유무,
     */
    public function checkUpdated()
    {
        return true;
    }

    /**
     * 플러그인의 설정페이지 주소를 반환한다.
     * 플러그인 목록에서 플러그인의 '관리' 버튼을 누를 경우 이 페이지에서 반환하는 주소로 연결된다.
     *
     * @return string
     */
    public function getSettingsURI()
    {
        return route('xe_popup::setting.index');
    }
}
