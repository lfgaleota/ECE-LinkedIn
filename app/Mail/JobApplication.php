<?php

namespace App\Mail;

use App\JobOffer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobApplication extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	public function __construct( User $applicant, JobOffer $offer, $coverLetter ) {
		$this->applicant = $applicant;
		$this->offer = $offer;
		$this->coverLetter = $coverLetter;
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.jobs.application', [
	        'applicant' => $this->applicant,
	        'coverLetter' => $this->coverLetter,
	        'offer' => $this->offer
        ]);
    }
}
