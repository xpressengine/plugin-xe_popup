<?php

return [
    'popup' => [
        'ko' => '팝업',
        'en' => 'Pop-up',
    ],
    'popupSetup' => [
        'ko' => '팝업 셋업',
        'en' => 'Pop-up Setup',
    ],
    'popupName' => [
        'ko' => '팝업 이름',
        'en' => 'Pop-up Name',
    ],
    'popupNameDescription' => [
        'ko' => '팝업 관리에 사용되는 이름입니다.',
        'en' => 'This is the name used for pop-up management.',
    ],
    'occurType' => [
        'ko' => '발생 타입',
        'en' => 'Occur Type',
    ],
    'occurTypeDescription' => [
        'ko' => '팝업이 발생하는 방식을 선택합니다.
<br><strong>메뉴모듈 방식</strong> : 사이트맵에서 설정한 메뉴에 페이지에 도달하면 실행됩니다. (메뉴 주소가 바뀌어도 설정이 유지됩니다.)
<br><strong>URL 방식</strong> : 지정한 URL 페이지에서 실행됩니다.',
        'en' => 'Choose how pop-ups occur.
<br><strong>Menu-module method</strong> : Executed when the page reaches the menu set in the site map. (The setting is retained even if the menu address is changed.)
<br><strong>URL method</strong> : Runs on the specified URL page.',
    ],
    'menuModule' => [
        'ko' => '메뉴모듈',
        'en' => 'Menu-Module',
    ],
    'url' => [
        'ko' => 'URL',
        'en' => 'URL',
    ],
    'occurModuleInfo' => [
        'ko' => '발생 모듈 정보 ',
        'en' => 'Occur module info',
    ],
    'occurModuleInfoDescription' => [
        'ko' => '메뉴모듈 타입일 때 실행할 위치를 선태하세요. 사이트맵에 설정된 모듈 목록에서 선택하세요.',
        'en' => 'Select a location to run when it is a menu module type. Select from the list of modules set in the sitemap.',
    ],
    'occurUrlInfo' => [
        'ko' => '발생 URL 정보',
        'en' => 'Occur URL info',
    ],
    'occurUrlInfoDescription' => [
        'ko' => 'URL 타입일 때 실행할 주소를 입력하세요.',
        'en' => 'Enter the address to be executed when the URL type is used.',
    ],
    'popupOpenType' => [
        'ko' => '팝업 오픈 타입',
        'en' => 'Pop-up open type',
    ],
    'layerPopup' => [
        'ko' => '레이어 팝업',
        'en' => 'Layer pop-up',
    ],
    'windowOpen' => [
        'ko' => 'window.open()',
        'en' => 'window.open()',
    ],
    'popupOpenTypeDescription' => [
        'ko' => '팝업 실행 방식을 선택합니다. <strong>window.open()</strong> 방식은 브라우저 환경에 따라 실행되지 않을 수 있습니다. ',
        'en' => 'Choose how to run the popup. The <strong>window.open()</strong> method may not work depending on the browser environment.',
    ],
    'popupContentType' => [
        'ko' => '팝업 콘텐츠 타입',
        'en' => 'Pop-up content type',
    ],
    'html' => [
        'ko' => 'HTML',
        'en' => 'HTML',
    ],
    'file' => [
        'ko' => 'File',
        'en' => 'File',
    ],
    'popupContentTypeDescription' => [
        'ko' => '팝업에 보여줄 콘텐츠 타입을 설정합니다.',
        'en' => 'Set the content type to be displayed in the pop-up.',
    ],
    'popupContentFile' => [
        'ko' => '팝업 콘텐츠 파일',
        'en' => 'Pop-up content file',
    ],
    'popupContentFileDescription' => [
        'ko' => '팝업에 표시할 파일을 업로드 하세요. html/이미지(jpg, gif, png)를 업로드 할 수 있습니다.',
        'en' => 'Upload the file to be displayed in the popup. You can upload html/images (jpg, gif, png).',
    ],
    'popupContentHtml' => [
        'ko' => '팝업 콘텐츠 HTML',
        'en' => 'Popup content HTML',
    ],
    'popupContentHtmlDescription' => [
        'ko' => '팝업에 표시할 HTML을 입력하세요. 파일 업로드가 필요하다면 미디어 라이브러리에 업로드 후 주소를 복사해서 사용하세요.',
        'en' => 'Enter the HTML to display in the popup. If you need to upload a file, upload it to the media library and copy the address to use.',
    ],
    'link' => [
        'ko' => '링크',
        'en' => 'Link',
    ],
    'linkDescription' => [
        'ko' => '콘텐츠 파일이 이미지일 때 이동할 링크를 입력하세요. (HTML을 사용할 경우 href="{{xe_popup.config.link}}" 를 입력하면 설정을 사용할 수 있습니다.) ',
        'en' => 'Enter the link to go to when the content file is an image. (If using HTML, the setting is available by entering href="{{xe_popup.config.link}}").',
    ],
    'linkTarget' => [
        'ko' => '링크 타켓',
        'en' => 'Link target',
    ],
    'linkTargetDescription' => [
        'ko' => '콘텐츠 파일이 이미지일 때 이동할 타켓을 입력하세요. (새창열기 :"_target"), (빈값이면 현재창에서 연결), (HTML을 사용할 경우 target="{{xe_popup.config.link_target}}" 를 입력하면 설정을 사용할 수 있습니다.) ',
        'en' => 'When the content file is an image, enter the target to move. (Open a new window:"_target"), (If the value is empty, connect in the current window), (If using HTML, enter target="{{{xe_popup.config.link_target}}" to use the setting.)',
    ],
    'size' => [
        'ko' => '크기',
        'en' => 'Size',
    ],
    'width' => [
        'ko' => '넓이',
        'en' => 'Width',
    ],
    'height' => [
        'ko' => '높이',
        'en' => 'height',
    ],
    'sizeDescription' => [
        'ko' => '팝업 크기를 입력하세요. (단위:px), (기본값 넓이:300, 높이:400)',
        'en' => 'Enter the popup size. (Unit:px), (Default width:300, height:400)',
    ],
    'position' => [
        'ko' => '위치',
        'en' => 'Position',
    ],
    'positionX' => [
        'ko' => 'X 좌표',
        'en' => 'X coordinate',
    ],
    'positionY' => [
        'ko' => 'Y 좌표',
        'en' => 'Y coordinate',
    ],
    'positionDescription' => [
        'ko' => '팝업이 나타날 위치를 입력하세요. (단위:px), (기본값 x:100, y:100)',
        'en' => 'Enter the location where the popup will appear. (Unit:px), (Default x:100, y:100)',
    ],
    'inactiveDays' => [
        'ko' => '비활성 기간',
        'en' => 'Inactive days',
    ],
    'inactiveDaysDescription' => [
        'ko' => '사용자가 하단에 생성되는 체크박스를 클릭하면 입력 값 동안 팝업이 보이지 않습니다. (단위:일), (기본값 1)',
        'en' => 'When the user clicks the checkbox created at the bottom, the pop-up is not shown during the input value. (Unit: day), (default 1)',
    ],
    'inactiveDaysMessage' => [
        'ko' => '빌활성 기간 메시지',
        'en' => 'Inactive days message',
    ],
    'inactiveDaysMessageDescription' => [
        'ko' => '사용자 하단에 생성되는 체크박스에 사용할 메시지입니다. (기본값 오늘 하루동안 보지 않음)',
        'en' => 'This is the message to be used for the checkbox created below the user. (default 오늘 하루동안 보지 않음)',
    ],
    'status' => [
        'ko' => '상태',
        'en' => 'Status',
    ],
    'statusDescription' => [
        'ko' => '팝업 사용 유무를 선택하세요.',
        'en' => 'Select whether to use pop-ups.',
    ],
    'exposeType' => [
        'ko' => '노출 타입',
        'en' => 'Exposure type',
    ],
    'period' => [
        'ko' => '기간',
        'en' => 'Period',
    ],
    'time' => [
        'ko' => '시간',
        'en' => 'Time',
    ],
    'exposeTypeDescription' => [
        'ko' => '노출 방식을 선택하세요. 
<br><strong>기간</strong> : 시작 일시부터 종료 일시까지 기간 동안 노출됩니다.
<br><strong>시간</strong> : 시작 일시부터 종료 일시까지 유효하며, 시작 시간부터 종료 시간에만 노출됩니다.',
        'en' => 'Choose an exposure method.
<br><strong>Period</strong>: Exposed for a period from start date to end date.
<br><strong>Time</strong>: Valid from the start date to the end date and time, and only exposed from the start time to the end time.',
    ],
    'start' => [
        'ko' => '시작',
        'en' => 'Start',
    ],
    'end' => [
        'ko' => '끝',
        'en' => 'End',
    ],
    'exposePeriod' => [
        'ko' => '노출 기간',
        'en' => 'Exposure period',
    ],
    'exposePeriodDescription' => [
        'ko' => '노출 기간을 입력하세요.',
        'en' => 'Enter the exposure period.',
    ],
    'exposeTime' => [
        'ko' => '노출 시간',
        'en' => 'Exposure time',
    ],
    'exposeTimeDescription' => [
        'ko' => '노출 시간을 입력하세요. 노출 타입이 시간일 경우에만 유효합니다.',
        'en' => 'Enter the exposure time. This is valid only when the exposure type is time.',
    ],
];
