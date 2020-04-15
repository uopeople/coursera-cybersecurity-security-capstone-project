/*
 * Table containing all registered users.
 */
CREATE TABLE 'users' (
    'id'                SERIAL NOT NULL UNIQUE PRIMARY KEY,
    'username'          VARCHAR(255) NOT NULL UNIQUE,
    'email'             VARCHAR(255) NOT NULL UNIQUE,
    'password'          VARCHAR(255) NOT NULL,
    'salt'              VARCHAR(255) NOT NULL,
    'password_reset'    BOOLEAN DEFAULT false,
    'login_ip'          INET,
    'login_attempts'    INT NOT NULL DEFAULT 0,
    'locked_time'       TIMESTAMP
);

/*
 * Table for password reset tokens.
 */
CREATE TABLE 'tokens' (
    'id'            SERIAL NOT NULL UNIQUE PRIMARY KEY,
    'user_id'       INT NOT NULL REFERENCES users(id),
    'reset_token'   VARCHAR(255) NOT NULL,
    'expiry'        TIMESTAMP NOT NULL,
    'used'          BOOLEAN NOT NULL DEFAULT false,
);

/*
 * Table containing all messages.
 */
CREATE TABLE 'messages' (
    'id'          SERIAL NOT NULL UNIQUE PRIMARY KEY,
    'sender'      INT NOT NULL REFERENCES users(id),
    'recipient'   INT NOT NULL REFERENCES users(id),
    'title'       VARCHAR(255) NOT NULL,
    'message'     TEXT NOT NULL,
    'date'        TIMESTAMP NOT NULL,
    'read'        BOOLEAN DEFAULT false
);
