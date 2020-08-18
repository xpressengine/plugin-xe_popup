<?php
namespace Xpressengine\Plugins\Popup\Models;

use Illuminate\Database\Eloquent\Model;

class PopupItem extends Model
{
    protected $table = 'popup_items';

    protected $casts = [
        'occur_type' => 'int',
        'poll_count' => 'int',
        'popup_open_type' => 'int',
        'size_width' => 'int',
        'size_height' => 'int',
        'position_x' => 'int',
        'position_y' => 'int',
        'disable_day' => 'float',
//        'started_at' => 'datetime',
//        'ended_at' => 'datetime',
        'status' => 'int',
    ];

    // set fillable all field
    protected $guarded = [];

    public function isImage()
    {
        if ($this->popup_content_file_path == '') {
            return false;
        }
        $parts = pathinfo($this->popup_content_file_path);

        if (in_array($parts['extension'], ['jpg', 'jpeg', 'gif', 'png']) == false) {
            return false;
        }
        return true;
    }
}
