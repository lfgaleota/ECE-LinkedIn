<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function read( $notification_id ) {
        $notif = Auth::user()->unreadNotifications->where( 'id', $notification_id );
        if( $notif == null ) {
            return response()->json( [ 'errors' => 'notification not found' ], 404 );
        }
        return response()->json( $notif->markAsRead() );
    }

}