<?php
// SOURCE :
// https://pecl.php.net/package/mongodb/1.13.0/windows
// https://www.php.net/manual/en/mongodb.tutorial.library.php

require '../vendor/autoload.php'; // include Composer's autoloader

// Create a new MongoDB client
$mongo = new MongoDB\Client('mongodb://localhost:27017');

// Create collections
$users = $mongo->Forum->users;

$topics = $mongo->Forum->topics;

$responds = $mongo->Forum->responds;


// Check if a user exists with the given email and password
function authenticateUser($email, $password) {
    global $users;

    // Find the user with the given email
    $user = $users->findOne(['email' => $email]);

    // Check if the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Return the user's ID
        return $user['_id'];
    }

    return false;
}

// Register a new user
function registerUser($email, $password, $firstName, $lastName) {
    global $users;

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the 'users' collection
    $result = $users->insertOne([
        'email' => $email,
        'password' => $hashedPassword,
        'firstName' => $firstName,
        'lastName' => $lastName
    ]);

    return $result->getInsertedId();
}

// Create a new topic
function createTopic($title, $description, $userId) {
    global $topics;

    // Insert the new topic into the 'topics' collection
    $result = $topics->insertOne([
        'title' => $title,
        'description' => $description,
        'user_id' => $userId
    ]);

    return $result->getInsertedId();
}

// Get all topics
function getTopics() {
    global $topics;

    // Find all topics in the 'topics' collection
    $cursor = $topics->find();

    // Return the topics as an array
    return iterator_to_array($cursor);
}

// Create a new response to a topic
function createResponds($topicId, $userId, $content) {
    global $responds;

    // Insert the new response into the 'responds' collection
    $result = $responds->insertOne([
        'topic_id' => new MongoDB\BSON\ObjectID($topicId),
        'content' => $content,
        'userId' => $userId
    ]);

    return $result->getInsertedId();
}

// Get all responds to a topic
function getRespondsByTopicId($topicId) {
    global $responds;
    // Find all responds with the given topic ID
    $cursor = $responds->find(['topic_id' => new MongoDB\BSON\ObjectID($topicId)]);

    // Return the responds as an array
    return iterator_to_array($cursor);
}

function getCountResponsesByTopicId($topicId) {
    global $responds;
    // Find all responds with the given topic ID
    $cursor = $responds->find(['topic_id' => new MongoDB\BSON\ObjectID($topicId)]);
    // Return the responds as an array
    return count($cursor->toArray());
}

function getAllResponds() {
    global $responds;

    // Find all responds in the 'responds' collection
    $cursor = $responds->find();

    // Return the responds as an array
    return iterator_to_array($cursor);
}

function getTopicById($topicId) {
    global $topics;

    // Find the topic with the given ID
    $topic = $topics->findOne(['_id' => new MongoDB\BSON\ObjectID($topicId)]);

    // Return the topic as an array
    return $topic;
}

function getUserNameById($userId) {
    global $users;

    // Find the user with the given ID
    $user = $users->findOne(['_id' => new MongoDB\BSON\ObjectID($userId)]);

    // Return the user's name
    return $user['firstName']." ".$user['lastName'];
}