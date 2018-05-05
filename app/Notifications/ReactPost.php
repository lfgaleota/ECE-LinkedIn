<?php

namespace App\Notifications;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReactPost extends Notification {
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct( User $sender, Post $post ) {
		$this->sender = $sender;
		$this->post = $post;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function via( $notifiable ) {
		return [ 'database' ];
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function toDatabase( $notifiable ) {
		return $this->toArray( $notifiable );
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function toArray( $notifiable ) {
		return [
			'sender' => $this->sender,
			'post' => $this->post
		];
	}
}
