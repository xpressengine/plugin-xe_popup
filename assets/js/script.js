function windowXePopup(url, args)
{
    var arrSpecs = {
        directories: 'no'
        , titlebar: 'no'
        , toolbar: 'no'
        , location: 'no'
        , status: 'no'
        , menubar: 'no'
        , scrollbars: 'no'
        , resizable: 'no'
    };

    arrSpecs.width = args.size_width;
    arrSpecs.height = args.size_height;
    arrSpecs.top = args.position_y;
    arrSpecs.left = args.position_x;

    var specs = '',
        indexCounter = 1,
        length = Object.keys(arrSpecs).length;

    $.each(arrSpecs, function (index, item) {
        specs += index + '=' + item;

        if (indexCounter < length) {
            specs += ',';
        }
        ++indexCounter;
    });

    try {
        var windowName = 'xe_popup_name_' + args.id;
        var w = window.open(url, windowName, specs);
        w.focus();
    } catch (e) {
        console.log(e);
        alert('팝업을 허용해 주세요.');
    }

}

function layerXePopup(args)
{
    console.log(args);

}

function setCookieXePopup( name, value, expiredays ) {
    var todayDate = new Date();
    todayDate.setDate( todayDate.getDate() + expiredays );
    document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}
function closeXePopup(id, expiredays, formId) {
    if ( document.forms[formId].chkbox.checked){
        setCookieXePopup( id, "done" , expiredays );
    }
    document.all[id].style.visibility = "hidden";
}

function oneDayCloseXePopup(id) {

  cookiedata = document.cookie;
  if ( cookiedata.indexOf(id+"=done") < 0 ){
    document.all[id].style.visibility = "visible";
  } else {
    document.all[id].style.visibility = "hidden";
  }
}

function setXePopup( id, top, left, width, height ) {

  document.all[id].style.top = top+'px';
  document.all[id].style.left = left+'px';
  document.all[id].style.width = width+'px';
  document.all[id].style.height = height+'px';
}

