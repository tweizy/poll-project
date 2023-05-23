CREATE DATABASE IF NOT EXISTS poll;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS Elections (
    election_id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    PRIMARY KEY (election_id)
);

CREATE TABLE IF NOT EXISTS Candidates (
    candidate_id INT NOT NULL AUTO_INCREMENT,
    election_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    photo VARCHAR(255) NOT NULL,   
    PRIMARY KEY (candidate_id),
    FOREIGN KEY (election_id) REFERENCES Elections(election_id)
);

CREATE TABLE IF NOT EXISTS Votes (
    vote_id INT NOT NULL AUTO_INCREMENT,
    election_id INT NOT NULL,
    user_id INT NOT NULL,
    vote VARCHAR(255) NOT NULL,
    vote_date DATETIME NOT NULL, 
    PRIMARY KEY (vote_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (election_id) REFERENCES Election(election_id)
);

CREATE TABLE IF NOT EXISTS Programs (
    program_id INT NOT NULL AUTO_INCREMENT,
    candidate_id INT NOT NULL,
    program_title VARCHAR(255) NOT NULL UNIQUE,
    program_description VARCHAR(255) NOT NULL,
    program_video VARCHAR(255) NOT NULL,
    program_affiche VARCHAR(255) NOT NULL,
    PRIMARY KEY (program_id),
    FOREIGN KEY (candidate_id) REFERENCES Candidates(candidate_id)
);