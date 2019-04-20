<?php

namespace Edu\snelson54\objectOriented;

require_once(dirname(__DIR__, 2) . "/composer.json/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Cross Section of Author
 *
 * This is a cross section of what is stored about an author.
 *
 * @author Sam Nelson <snelson54@cnm.edu>
 * @version 1.0.0
 **/

class author {
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * avatar for this Author; this is a unique index
	 * @var string $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * token handed out to verify that the author is valid and not malicious.
	 *v@var $profileActivationToken
	 **/
	private $authorActivationToken;
	/**
	 * email for this Profile; this is a unique index
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * hash for author password
	 * @var $authorHash
	 **/
	private $authorHash;
	/**
	 * username for this Author
	 * @var string $authorUsername
	 **/
	private $authorUsername;

	public function getauthorId(): Uuid {
		return ($this->authorId);
	}
	/**
	 * mutator method for Author id
	 *
	 * @param  Uuid| string $newAuthorId value of new author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if the author Id is not
	 **/


}
