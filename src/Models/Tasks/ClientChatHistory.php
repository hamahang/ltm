<?php

namespace Hamahang\LTM\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientChatHistory extends Model
{
    protected $table = 'ltm_client_chat_history';

    use SoftDeletes ;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id') ;
    }

    public function getAvatarImageAttribute()
    {
        $res = route('File.DownloadFile', ['type' => 'ID', 'id' => $this->user->avatar_file_id ? enCodeId($this->user->avatar_file_id) : -1, 'default_img' => 'user_avatar.png']);
        return '<img src="'.$res.'" style="height:53px;width:53px;border-radius:50%">';
    }

}
