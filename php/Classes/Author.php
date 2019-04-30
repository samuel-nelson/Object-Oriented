<?php
namespace Snelson54\ObjectOriented;
require_once(dirname(__DIR__) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 *@author Sam Nelson <snelson54@cnm.edu>
 **/
class Author {
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * token is handed out to verify that the Author is valid and not malicious.
	 * @var $authorActivationToken
	 **/
	private $authorActivationToken;
	/**
	 *
	 *
	 **/
	private $authorAvatarUrl;
	/**
	 * email for this Author; this is a unique index
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * hash for author password
	 * @var string $authorHash
	 **/
	private $authorHash;
	/**
	 * username for this author
	 * @var string fro $authorUsername
	 **/
	private $authorUsername;
	/**
	 * salt for author password
	 * @var $authorSalt
	 **/
	private $authorSalt;
	/**
	 * constructor for author
	 *
	 *
	 */
	public function __construct(string $newAuthorId, string $newauthorAvatarUrl, string $newAuthorActivationToken, string $newAuthorEmail, string $newAuthorUsername, string $newAuthorHash) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorAvatarUrl($newauthorAvatarUrl);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorUsername($newAuthorUsername);
			$this->setAuthorHash($newAuthorHash);
		}
		catch(\InvalidArgumentException | \RangeException |\Exception | \TypeError $exception) {
			echo "You Goofed";
		}
	}
	/**
	 * accessor method for authorId
	 * @return Uuid value of authorId (or null if new Author)
	 */
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}
	/**
	 * mutator method for authorId
	 *
	 * @param Uuid| string $newAuthorId value of new authorId
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if the authorId is not a string
	 */
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the authorId
		$this->authorId = $uuid;
	}
	/**
	 * accessor methd for author activation token
	 *
	 * @return string value of the activation token
	 */
	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken);
	}
	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}
	/**
	 * accessor method for avatar url
	 *
	 * @param string $newAuthorAvatarUrl
	 * @throws \InvalidArgumentException if $newAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAvatarUrl is > 32 characters
	 * @throws \TypeError if $newAvatarUrl is not a string
	 */
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		// verify that the Url is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("author url is empty or insecure"));
		}
		// verify the url will fit in the database
		if(strlen($newAuthorAvatarUrl) > 32) {
			throw(new \rangeException("author url is too large"));
		}
		//store the url
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}
	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 */
	public function getAuthorEmail(): string {
		return $this->authorEmail;
	}
	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 */
	public function setAuthorEmail(string $newAuthorEmail): void {
		//verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("author email is empty or insecure"));
		}
		//verify the email will fit in the datatbase
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email is too large"));
		}
		//store the email
		$this->authorEmail = $newAuthorEmail;
	}
	/**
	 * accessor method for authorHash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	}
	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if author hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}
	/**
	 * accessor method for username
	 *
	 * @return string value of username or null
	 **/
	public function getAuthorUsername(): ?string {
		return ($this->authorUsername);
	}
	/**
	 * mutator method for username
	 *
	 * @param string $newAuthorUsername new value of username
	 * @throws \InvalidArgumentException if $newUsername is not a string or insecure
	 * @throws \RangeException if $newUsername is > 32 characters
	 * @throws \TypeError if $newUsername is not a string
	 */
	public function setAuthorUsername(?string $newAuthorUsername): void {
		//if $authorUsername is null return it right away
		if($newAuthorUsername === null) {
			$this->authorUsername = null;
			return;
		}
		// verify the username is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author username is empty or insecure"));
		}
		// verify the username will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("author username is too large"));
		}
		// store the username
		$this->authorUsername = $newAuthorUsername;
	}
	/**
	 * inserts author into mySQL
	 * @param \PDO $pdo
	 * @throws \PDOException when mySql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		$query = "INSERT INTO Author(authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorUsername, authorHash) VALUES (:authorId, :authorAvatarUrl, :authorActivationToken, :authorEmail, :authorUsername, :auhtorHash)";
						$statement = $pdo->prepare($query);

						$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" =>$this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorUsername" => $this->authorUsername, "authorHash" => $this->authorHash];
						$statement->execute($parameters);
	}
	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo
	 */
	public function delete(\PDO $pdo) : void {
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}
	/** updates this author in mySQL
	*
	* @param \PDO $pdo PDO connection object
	* @throws \PDOException when mySQL related errors occur
	* @throws \TypeError if $pdo is not a PDO connection object
	*/
	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE author SET authorAvatarUrl = ;authorAvatarUrl, authorActivationToken = :authorActivationToken, authorEmail = :authorEmail, authorUsername = :authorUsername, authorHash = :authorHash WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" =>$this->authorAvatarUrl, "authorActivationToken" => $this->authorActivationToken, "authorEmail" => $this->authorEmail, "authorUsername" => $this->authorUsername, "authorHash" => $this->authorHash];
		$statement->execute($parameters);
	}
	/**
	 * gets the author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
	//create query template
	$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorUsername, authorHash FROM author WHERE authorId = :authorId";

	$statement = $pdo->prepare($query);

	// bind the author id to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
	$statement->execute($parameters);

	//grab the author from mySQL
	try {
		$author = null;
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if (row !== false) {
			$author = new Author($row["authorId"], $row["authorAvatarUrl"], $row["authorActivationToken"], $row["authorEmail"], $row["authorUsername"], $row["authorHash"]);
		}
	} catch (\Exception $exception) {
		//if the row couldn't be converted, rethrow it
		throw(new \PDOException($exception->getMessage(), 0, $exception));
	}
	return($author);
	}
	/**
	 * gets all authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of authors found or null if not found
	 *
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError whe variables are not in the correct data type
	 */
	public static function getAllAuthors(PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorUsername, authorHash";

		$statement = $pdo->prepare($query);
		$statement->execute();

//build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try{
				$author = new Author($row["authorId"], $row["authorAvatarUrl"], ["authorActivationToken"], ["authorEmail"], ["authorUsername"], ["authorHash"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($authors);
	}
}
