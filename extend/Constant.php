<?php

class Constant
{
    const ACTIVITY_CREATE = 0;
    const ACTIVITY_HAS_REGISTERED = 1;
    const ACTIVITY_APPLYING = 2;
    const ACTIVITY_DENIED=3;
    const SUCCESS="success";
    const FAILED="failed";
    const NOT_EXISTS="not exists";
    const HAS_JOINED="has joined";


//    //state : 1 好友, 2请求添加, 3 请求被添加, 4 请求被拒绝, 5拒绝请求，6 我被对方删除
//    //Friend
//    const FRIEND_STATE_FRIEND=1;
//    const FRIEND_STATE_REQUEST=2;
//    const FRIEND_STATE_REQUESTED=3;
//    const FRIEND_STATE_REQUEST_DENYED=4;
//    const FRIEND_STATE_REQUEST_DENY=5;
//    const FRIEND_STATE_DELETED=6;
//    const REQUEST_HAS_SENT="request_has_sent";
//    const ALREADY_FRIEND="already_friend";
//
//
    const ALL_USERS_TABLENAME="all_users";
//    const FRIEND_REQUEST_TYPE='friend_request_type';

    const ALL_ACTIVITIES_TABLE="all_activities";

    const DATABASE_NAME="callsports";
    const ALL_USERS_TABLE="all_users";
    const FRIENDS_SUFFIX="_friendsinfo";
    const ACTIVITY_SUFFIX="_activity";

    const USER_NOT_EXISTS="user_not_exists";
    const LOGIN_FAILED="login_failed";
    const TOKEN_EXPIRED="token_expired";


    const SYSTEM_USER="system";

    const SPORT_TYPE_MAP=['足球'=>"football.png",'篮球'=>"basketball.jpg",'台球'=>"billiards.jpg"];
//public const ACTIVITY_REGISTER=2;
}