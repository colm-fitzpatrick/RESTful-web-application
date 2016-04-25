<?php
/* database constants */
define("DB_HOST", "127.0.0.1" ); 		// set database host
define("DB_USER", "root" ); 			// set database user
define("DB_PASS", "" ); 				// set database password
define("DB_PORT", 3306);				// set database port
define("DB_NAME", "week6_lab" ); 				// set database name
define("DB_CHARSET", "utf8" ); 			// set database charset
define("DB_DEBUGMODE", true ); 			// set database charset
define("DB_VENDOR"	, "mysql");			// set database vendore


/* actions for the USERS REST resource */
define("ACTION_GET_USER", 33);
define("ACTION_GET_USERS", 44);
define("ACTION_CREATE_USER", 55);
define("ACTION_UPDATE_USER", 66);
define("ACTION_DELETE_USER", 77);
define("ACTION_SEARCH_USERS", 88);
define("ACTION_GET_HEADER", 99);

/* actions for the MOVIES REST resource */
define("ACTION_GET_MOVIE", 100);
define("ACTION_GET_MOVIES", 101);
define("ACTION_CREATE_MOVIE", 102);
define("ACTION_UPDATE_MOVIE", 103);
define("ACTION_DELETE_MOVIE", 104);
define("ACTION_SEARCH_MOVIES", 105);

/* actions for the MOVIE_RATINGS REST resource */
define("ACTION_GET_MOVIE_RATING", 106);
define("ACTION_GET_MOVIES_RATING", 107);
define("ACTION_CREATE_MOVIE_RATING", 108);
define("ACTION_UPDATE_MOVIE_RATING", 109);
define("ACTION_DELETE_MOVIE_RATING", 110);
define("ACTION_SEARCH_MOVIES_RATING", 111);

/* HTTP status codes 2xx*/
define("HTTPSTATUS_OK", 200);
define("HTTPSTATUS_CREATED", 201);
define("HTTPSTATUS_NOCONTENT", 204);

/* HTTP status codes 3xx (with slim the output is not produced i.e. echo statements are not processed) */
define("HTTPSTATUS_NOTMODIFIED", 304);

/* HTTP status codes 4xx */
define("HTTPSTATUS_BADREQUEST", 400);
define("HTTPSTATUS_UNAUTHORIZED", 401);
define("HTTPSTATUS_FORBIDDEN", 403);
define("HTTPSTATUS_NOTFOUND", 404);
define("HTTPSTATUS_REQUESTTIMEOUT", 408);
define("HTTPSTATUS_TOKENREQUIRED", 499);

/* HTTP status codes 5xx */
define("HTTPSTATUS_INTSERVERERR", 500);

define("TIMEOUT_PERIOD", 120);

/* general message */
define("GENERAL_MESSAGE_LABEL", "message");
define("GENERAL_SUCCESS_MESSAGE", "success");
define("GENERAL_ERROR_MESSAGE", "error");
define("GENERAL_NOCONTENT_MESSAGE", "no-content");
define("GENERAL_NOTMODIFIED_MESSAGE", "not modified");
define("GENERAL_INTERNALAPPERROR_MESSAGE", "internal app error");
define("GENERAL_CLIENT_ERROR", "client error: modify the request");
define("GENERAL_INVALIDTOKEN_ERROR", "Invalid token");
define("GENERAL_APINOTEXISTING_ERROR", "Api is not existing");
define("GENERAL_RESOURCE_CREATED", "Resource has been created");
define("GENERAL_RESOURCE_UPDATED", "Resource has been updated");
define("GENERAL_RESOURCE_DELETED", "Resource has been deleted");
define("GENERAL_INVALID_EMAIL", "Your email address is invalid. Please enter a valid address");

define("GENERAL_FORBIDDEN", "Request is ok but action is forbidden");
define("GENERAL_INVALIDBODY", "Request is ok but transmitted body is invalid");

define("GENERAL_WELCOME_MESSAGE", "Welcome to DIT web-services");
define("GENERAL_INVALIDROUTE", "Requested route does not exist");


/* representation of a new user in the DB */
define("TABLE_USER_NAME_LENGTH", 25);
define("TABLE_USER_SURNAME_LENGTH", 25);
define("TABLE_USER_EMAIL_LENGTH", 50);
define("TABLE_USER_PASSWORD_LENGTH", 40);

/* representation of a new movie in the DB */
define("TABLE_MOVIES_NAME_LENGTH", 40);
define("TABLE_MOVIES_GENRE_LENGTH", 30);
define("TABLE_MOVIES_DESCRIPTION_LENGTH", 150);

/* representation of a new movie rating in the DB */
define("TABLE_MOVIESRATING_NAME_LENGTH", 40);
define("TABLE_MOVIESRATING_COMMENT_LENGTH", 100);
define("TABLE_MOVIESRATING_RATING_MIN", 1);
define("TABLE_MOVIESRATING_RATING_MAX", 10);

?>