<?php

namespace App\Notifications;

use App\JobOffer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobApplication extends Notification {
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct( User $applicant, JobOffer $offer, $coverLetter ) {
		$this->applicant = $applicant;
		$this->offer = $offer;
		$this->coverLetter = $coverLetter;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function via( $notifiable ) {
		return [ 'mail' ];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail( $notifiable ) {
		return ( new \App\Mail\JobApplication( $this->applicant, $this->offer, $this->coverLetter ) )->to( $this->offer->author->email );
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function toArray( $notifiable ) {
		return [
			'applicant' => $this->applicant,
			'coverLetter' => $this->coverLetter,
			'offer' => $this->offer
		];
	}
}
