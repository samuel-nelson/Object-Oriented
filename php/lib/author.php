<?php
/**
* constructor for this Tweet
*
* @param string|Uuid $newTweetId id of this Tweet or null if a new Tweet
* @param string|Uuid $newTweetProfileId id of the Profile that sent this Tweet
* @param string $newTweetContent string containing actual tweet data
* @param \DateTime|string|null $newTweetDate date and time Tweet was sent or null if set to current date and time
* @throws \InvalidArgumentException if data types are not valid
* @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
* @throws \TypeError if data types violate type hints
* @throws \Exception if some other exception occurs
* @Documentation https://php.net/manual/en/language.oop5.decon.php
**/
public function __construct($newTweetId, $newTweetProfileId, string $newTweetContent, $newTweetDate = null) {
try {
$this->setTweetId($newTweetId);
$this->setTweetProfileId($newTweetProfileId);
$this->setTweetContent($newTweetContent);
$this->setTweetDate($newTweetDate);
}2
//determine what exception type was thrown
catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
$exceptionType = get_class($exception);
throw(new $exceptionType($exception->getMessage(), 0, $exception));
}
}







/**
* inserts this Tweet into mySQL
*
* @param \PDO $pdo PDO connection object
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError if $pdo is not a PDO connection object
**/
public function insert(\PDO $pdo) : void {

// create query template
$query = "INSERT INTO tweet(tweetId,tweetProfileId, tweetContent, tweetDate) VALUES(:tweetId, :tweetProfileId, :tweetContent, :tweetDate)";
$statement = $pdo->prepare($query);

// bind the member variables to the place holders in the template
$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
$parameters = ["tweetId" => $this->tweetId->getBytes(), "tweetProfileId" => $this->tweetProfileId->getBytes(), "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
$statement->execute($parameters);
}


/**
* deletes this Tweet from mySQL
*
* @param \PDO $pdo PDO connection object
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError if $pdo is not a PDO connection object
**/
public function delete(\PDO $pdo) : void {

// create query template
$query = "DELETE FROM tweet WHERE tweetId = :tweetId";
$statement = $pdo->prepare($query);

// bind the member variables to the place holder in the template
$parameters = ["tweetId" => $this->tweetId->getBytes()];
$statement->execute($parameters);
}

/**
* updates this Tweet in mySQL
*
* @param \PDO $pdo PDO connection object
* @throws \PDOException when mySQL related errors occur
* @throws \TypeError if $pdo is not a PDO connection object
**/
public function update(\PDO $pdo) : void {

// create query template
$query = "UPDATE tweet SET tweetProfileId = :tweetProfileId, tweetContent = :tweetContent, tweetDate = :tweetDate WHERE tweetId = :tweetId";
$statement = $pdo->prepare($query);


$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
$parameters = ["tweetId" => $this->tweetId->getBytes(),"tweetProfileId" => $this->tweetProfileId->getBytes(), "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
$statement->execute($parameters);
}
