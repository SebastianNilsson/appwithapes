<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redis;

class ChatController extends Controller
{

    const CHAT_CHANNEL = 'chat.message';
    const NEW_MSG_CHANNEL = 'new.msg';
    const DELETE_MSG_CHANNEL = 'del.msg';

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public static function online()
    {
        $redis = Redis::connection();
        return $redis->get('online');

    }

    public static function chat()
    {
        $redis = Redis::connection();

        $value = $redis->lrange(self::CHAT_CHANNEL, 0, -1);
        $i = 0;
        $returnValue = NULL;
        $value = array_reverse($value);

        foreach ($value as $key => $newchat[$i]) {
            if ($i > 20) {
                break;
            }
            $value2[$i] = json_decode($newchat[$i], true);


            $value2[$i]['username'] = htmlspecialchars($value2[$i]['username']);
            $value2[$i]['messages'] = str_replace(":)", "<img style='background-position: 0px 0px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":-d", "<img style='background-position: 0px -17px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(";-)", "<img style='background-position: 0px -34px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("xd", "<img style='background-position: 0px -51px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(";-p", "<img style='background-position: 0px -68px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":-p", "<img style='background-position: 0px -85px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("8-)", "<img style='background-position: 0px -102px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("b-)", "<img style='background-position: 0px -119px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":-(", "<img style='background-position: 0px -136px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(";-]", "<img style='background-position: 0px -153px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("u—(", "<img style='background-position: 0px -170px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":l(", "<img style='background-position: 0px -187px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":_(", "<img style='background-position: 0px -204px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":((", "<img style='background-position: 0px -221px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":o", "<img style='background-position: 0px -238px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":|", "<img style='background-position: 0px -255px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("3-)", "<img style='background-position: 0px -272px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("o*)", "<img style='background-position: 0px -323px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(";o", "<img style='background-position: 0px -340px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("8o", "<img style='background-position: 0px -374px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("8|", "<img style='background-position: 0px -357px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":x", "<img style='background-position: 0px -391px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("*3", "<img style='background-position: 0px -442px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":-*", "<img style='background-position: 0px -409px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace("}^)", "<img style='background-position: 0px -425px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(">((", "<img style='background-position: 0px -306px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(">(", "<img style='background-position: 0px -289px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":like:", "<img style='background-position: 0px -459px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":dislike:", "<img style='background-position: 0px -476px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":u:", "<img style='background-position: 0px -493px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":v:", "<img style='background-position: 0px -510px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":kk:", "<img style='background-position: 0px -527px' id=smile src=/images/chat/white.gif>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm1:", "<img style='background:none;' id=smile src=/images/chat/D83DDC4F.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm2:", "<img style='background:none;' id=smile src=/images/chat/D83DDC4A.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm3:", "<img style='background:none;' id=smile src=/images/chat/270B.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm4:", "<img style='background:none;' id=smile src=/images/chat/D83DDE4F.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm5:", "<img style='background:none;' id=smile src=/images/chat/D83DDC43.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm6:", "<img style='background:none;' id=smile src=/images/chat/D83DDC46.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm7:", "<img style='background:none;' id=smile src=/images/chat/D83DDC47.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm8:", "<img style='background:none;' id=smile src=/images/chat/D83DDC48.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm9:", "<img style='background:none;' id=smile src=/images/chat/D83DDCAA.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm10:", "<img style='background:none;' id=smile src=/images/chat/D83DDC42.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm11:", "<img style='background:none;' id=smile src=/images/chat/D83DDC8B.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm12:", "<img style='background:none;' id=smile src=/images/chat/D83DDCA9.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm13:", "<img style='background:none;' id=smile src=/images/chat/2744.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm14:", "<img style='background:none;' id=smile src=/images/chat/D83CDF77.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm15:", "<img style='background:none;' id=smile src=/images/chat/D83CDF78.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm16:", "<img style='background:none;' id=smile src=/images/chat/D83CDF85.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm17:", "<img style='background:none;' id=smile src=/images/chat/D83DDCA6.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm18:", "<img style='background:none;' id=smile src=/images/chat/D83DDC7A.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm19:", "<img style='background:none;' id=smile src=/images/chat/D83DDC28.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm20:", "<img style='background:none;' id=smile src=/images/chat/D83CDF4C.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm21:", "<img style='background:none;' id=smile src=/images/chat/D83CDFC6.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm22:", "<img style='background:none;' id=smile src=/images/chat/D83CDFB2.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm23:", "<img style='background:none;' id=smile src=/images/chat/D83CDF7A.png>", $value2[$i]['messages']);
            $value2[$i]['messages'] = str_replace(":sm24:", "<img style='background:none;' id=smile src=/images/chat/D83CDF7B.png>", $value2[$i]['messages']);


            $returnValue[$i] = [
                'userid' => $value2[$i]['userid'],
                'avatar' => $value2[$i]['avatar'],
                'time' => $value2[$i]['time'],
                'time2' => $value2[$i]['time2'],
                'support' => $value2[$i]['support'],
                'messages' => $value2[$i]['messages'],
                'username' => $value2[$i]['username'],
                'admin' => $value2[$i]['admin']];

            $i++;

        }

       // if (!is_null($returnValue)) return array_reverse($returnValue);

        return $returnValue;
    }


    public function __destruct()
    {
        $this->redis->disconnect();
    }

    public function delete_message(Request $request)
    {

        $value = $this->redis->lrange(self::CHAT_CHANNEL, 0, -1);
        $i = 0;
        $json = json_encode($value);
        $json = json_decode($json);
        foreach ($json as $newchat) {
            $val = json_decode($newchat);

            if ($val->time2 == $request->get('messages')) {
                $this->redis->lrem(self::CHAT_CHANNEL, 1, json_encode($val));
                $this->redis->publish(self::DELETE_MSG_CHANNEL, json_encode($val));
            }
            $i++;
        }


        return response()->json(['success' => 'Сообщение удалено !']);
    }




    public function add_message(Request $request)
    {


        $val = \Validator::make($request->all(), [
            'messages' => 'required|string|max:255'
        ],[
            'required' => 'Сообщение не может быть пустым!',
            'string' => 'Сообщение должно быть строкой!',
            'max' => 'Максимальный размер сообщения 255 символов.',
        ]);
        $error = $val->errors();

        if($val->fails()){
            return response()->json(['errors' => $error->first('messages')]);
        }

        $messages = $request->get('messages');
        // if (!$this->user->is_admin) {
        if (\Cache::has('addmsg.user.' . $this->user->id)) return response()->json(['errors' => 'Вы слишком часто отправляете сообщения!']);
        \Cache::put('addmsg.user.' . $this->user->id, '', 0.05);
        //}
        if ($this->user->banchat == 1) {
            return response()->json(['errors' => 'Вы забанены в чате ! Срок : Навсегда']);
        }


        $support = $this->user->support;
        $admin = $this->user->is_admin;
        $avatar = $this->user->avatar;
        if ($admin) {
            $avatar = '/images/10709.gif';
        }
        $userid = $this->user->id;
        if ($support) {
            $avatar = '/images/support.png';
            $support = 1;
            $admin = 0;
        } else {
            $support = 0;
            $admin = $this->user->is_admin;
        }


        $username = htmlspecialchars($this->user->username);
        if ($admin) {
            $username = 'ADMIN #1';
        }
        $time = date('H:i', time());


        //if(Game::where('userid'  ,  '=', $this->user->id)->where('case',  '!=', 0)->first() == null)return response()->json(['errors'=>'Вы должны купить один билет']);


        function object_to_array($data)
        {
            if (is_array($data) || is_object($data)) {
                $result = array();
                foreach ($data as $key => $value) {
                    $result[$key] = object_to_array($value);
                }
                return $result;
            }
            return $data;
        }

        $words = file_get_contents(dirname(__FILE__) . '/words.json');
        $words = object_to_array(json_decode($words));

        foreach ($words as $key => $value) {
            $messages = str_ireplace($key, $value, $messages);
        }


        if ($this->user->is_admin) {
            if (substr_count($messages, '/clear')) {

                $this->redis->del(self::CHAT_CHANNEL);
                return response()->json(['success' => 'Вы отчистили чат']);
            }

        } else {


            if (preg_match("/href|url|http|www|.ru|.com|.net|.info|.org/i", $messages)) {

                return response()->json(['errors' => 'Ссылки запрещены !']);
            }

        }
        $returnValue = ['userid' => $userid, 'avatar' => $avatar, 'time2' => Carbon::now()->getTimestamp(), 'time' => $time, 'messages' => htmlspecialchars($messages), 'username' => $username,
            'support' => $support,
            'admin' => $admin];
        $this->redis->rpush(self::CHAT_CHANNEL, json_encode($returnValue));
        //     $this->redis->rpush(self::CHAT_CHANNEL, json_encode(['userid' => 0, 'avatar' => '/images/bot.gif', 'time' =>$time, 'messages' => htmlspecialchars('Хай бро'), 'username' =>'Бот' , 'admin' => $admin]));

        $this->redis->publish(self::NEW_MSG_CHANNEL, json_encode($returnValue));

//return response()->json(['succes'=>'Ваше сообщение отправлено']);

    }


}
