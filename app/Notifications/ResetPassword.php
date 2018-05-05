<?php

namespace App\Notifications;

use \Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordNotification {
	/**
	 * Build the mail representation of the notification.
	 *
	 * @param  mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail( $notifiable ) {
		return ( new MailMessage )
			->line( 'Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.' )
			->action( 'Réinitialiser le mot de passe', url( config( 'app.url' ) . route( 'password.reset', $this->token, false ) ) )
			->line( "Si vous n'avez pas demandé la réinitialisation du mot de passe, aucune autre action n'est requise." );
	}
}
