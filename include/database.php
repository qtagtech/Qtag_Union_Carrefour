<?php
/**
 * Database.php
 * 
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 17, 2004
 */
include("constants.php");
      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
      
      /**
       * Only query database to find out number of members
       * when getNumMembers() is called for the first time,
       * until then, default value set.
       */
      $this->num_members = -1;
      
      if(TRACK_VISITORS){
         /* Calculate number of users at site */
         $this->calcNumActiveUsers();
      
         /* Calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   }

   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT password,activated FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

		/* Validate if user has confirmed email */
		if($dbarray[activated] == 0)
		{
			return 3; //indicates not confirmed email.
		}      
      /* Validate that password is correct */
      else if($password == $dbarray['password']){
         return 0; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
      }
   }
   
   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }
   
   /**
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
   
   /**
    * usernameBanned - Returns true if the username has
    * been banned by the administrator.
    */
   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
   
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($username, $password, $email,$name,$lastname,$age,$documentype,$document,$gender,$address,$mobile,$facebook,$twitter,$store,$city,$position,$notifications){
      $time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }else{
         $ulevel = USER_LEVEL;
      }
      $q = "INSERT INTO ".TBL_USERS." VALUES ('$username', '$password', '0', $ulevel, '$email','$name','$lastname','$age','$documentype','$document','$gender','$address','$mobile','$facebook','$twitter','$store','$city','$position','$notifications', $time,$time,1)";
      return mysql_query($q, $this->connection);
   }
   
   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateUserField($username, $field, $value){
      $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username'";
      return mysql_query($q, $this->connection);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysql_query($q, $this->connection);
      /* Error occurred, return given name by default */
      if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   }
   
   /**
    * getNumMembers - Returns the number of signed-up users
    * of the website, banned members not included. The first
    * time the function is called on page load, the database
    * is queried, on subsequent calls, the stored result
    * is returned. This is to improve efficiency, effectively
    * not querying the database when no call is made.
    */
   function getNumMembers(){
      if($this->num_members < 0){
         $q = "SELECT * FROM ".TBL_USERS;
         $result = mysql_query($q, $this->connection);
         $this->num_members = mysql_numrows($result);
      }
      return $this->num_members;
   }
   
   /**
    * calcNumActiveUsers - Finds out how many active users
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_users = mysql_numrows($result);
   }
   
   /**
    * calcNumActiveGuests - Finds out how many active guests
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_guests = mysql_numrows($result);
   }
   
   /**
    * addActiveUser - Updates username's last active timestamp
    * in the database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    */
   function addActiveUser($username, $time){
      $q = "UPDATE ".TBL_USERS." SET timestamp = '$time' WHERE username = '$username'";
      mysql_query($q, $this->connection);
      
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$username', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   /* addActiveGuest - Adds guest to active guests table */
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time')";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /* These functions are self explanatory, no need for comments */
   
   /* removeActiveUser */
   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   /* removeActiveGuest */
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /* removeInactiveUsers */
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-USER_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }

   /* removeInactiveGuests */
   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < $timeout";
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   /**
   *Funciones de Noticias
   *
   **/
   
   function getAllNews()
   {
   	$q = "SELECT site_articles.id, site_articles.autor, site_articles.titulo, site_articles.subtitulo, site_articles.texto, site_articles.seccion, site_articles.keywords, site_articles.timestamp, site_articles.type FROM site_articles UNION SELECT user_Articles.id, user_Articles.autor, user_Articles.titulo, user_Articles.subtitulo, user_Articles.texto, user_Articles.seccion, user_Articles.keywords, user_Articles.timestamp, user_Articles.type FROM user_Articles ORDER BY timestamp ASC LIMIT 6";
		$result = $this->query($q);
		if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      //$dbarray = mysql_fetch_array($result);
      return $result;
		   
   }
   
   function getPositions($positions) {
		$i = 0;
		$whereclause = "";   	
   	while($positions[$i]) 
   	{
   		$whereclause .= "site_positions.name = "."'$positions[$i]'";
   		if($positions[$i+1]) $whereclause .= " OR ";
   		$i++;
		}   	
		$q = "SELECT site_positions.name, site_articles.autor, site_articles.titulo, site_articles.texto, site_articles.seccion FROM site_positions LEFT JOIN site_articles ON site_articles.id = site_positions.article_id WHERE $whereclause";
		
		//$q = "SELECT ".TBL_POS."name,".TBL_ARTICLES.".autor,".TBL_ARTICLES.".titulo,".TBL_ARTICLES.".texto,".TBL_ARTICLES.".seccion FROM site_positions LEFT JOIN ".TBL_ARTICLES." on ".TBL_ARTICLES.".id = ".TBL_POS.".article_id"; 
		$result = $this->query($q);
		  	if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      
      $noticias = NULL;
      while($actual = mysql_fetch_array($result))
      {
      	$noticias[$actual[name]] = array('titulo'=>$actual[titulo],'autor'=>$actual[autor],'texto'=>$actual[texto]); //aca seponen las imágenes en un array todas las que tenga con el id, y se pone la categoria en una array que tenga id y nombre para hacer link
      }
		
      return $noticias;
      
   	}
	
   	
   	function saveArticle($title,$content,$u) {
   		
   		$date = time();
   		
   		$q = "INSERT INTO ".TBL_ARTICLES." VALUES ('','$u','$title','','$content',1,'',$date)";
      	$res = mysql_query($q,$this->connection) or die(mysql_error($this->connection));
      	return $res;
   		
   		}
   		
		function saveFile($name, $ruta, $desc)
		{
			$q = "INSERT INTO File VALUES ('', '$name', '$ruta', '$desc')";
			$RES = mysql_query($q, $this->connection) or die(mysql_error($this->connection));
			return $res;
		}
		
		function saveImage($name, $ruta, $desc){
			$q = "INSERT INTO media VALUES ('','$name', 1,'$ruta', '', '$desc')";
			$res = mysql_query($q, $this->connection) or die(mysql_error($this->connection));
			return $res;
		}
		function deleteImage($id){
			$q = "DELETE FROM media WHERE id = $id";
			$res = mysql_query($q, $this->connection)or die(mysql_error($this->connection));
			return $res;
		}
		
   		function deleteArticle($id) {
   		
   		
   		
   		$q = "DELETE FROM ".TBL_ARTICLES." WHERE id = $id";
      	$res = mysql_query($q,$this->connection) or die(mysql_error($this->connection));
      	return $res;
   		
   		}
   		
   		function updateArticle($t,$c,$id) {
				$q = "UPDATE ".TBL_ARTICLES." SET titulo = '$t', texto = '$c' WHERE id = $id";
				$res = $this->query($q);
				return $res;				   			
   			}
   			
	function publishArticle($art,$pos) {
				$q = "UPDATE ".TBL_POS." SET article_id = $art WHERE id = $pos";
				$res = $this->query($q);
				return $res;				   			
   			}
   	function saveUserArticle($title, $content, $u){
		$date = time();
		$q = "INSERT INTO user_Articles VALUES ('', '$u', '$title', '', '$content', 1, '', $date)";
		$res = mysql_query($q, $this-> connection) or die(mysql_error($this->connection));
		return $res;
	}	
	function deleteUserArticle($id){
			$q = "DELETE FROM user_Articles WHERE id = $id";
			$res = mysql_query($q, $this->connection) or die(mysql_error($this->connection));
			return $res;
	}

	function updateUserArticle($t, $c, $id){
			$q = "UPDATE user_Articles SET titulo = '$t', texto = '$c' WHERE id = $id";
			$res = $this-> query($q);
			return $res;
	}
	
	function buscarCedula($d)
	{
		
		$q = "SELECT username, userid, userlevel, email, name, lastname, age, documenttype, document, gender, address, mobile, facebook, twitter, store, city, position, notifications FROM users WHERE document = '$d'";
		$res = $this -> query ($q);
		
		return $res;
	}
	function buscarNombre($d)
	{
		$q = "SELECT username, userid, userlevel, email, name, lastname, age, documenttype, document, gender, address, mobile, facebook, twitter, store, city, position, notifications FROM users WHERE name like '%$d%'";
		$res = $this->query($q);
		return $res;
	}
	
	
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return mysql_query($query, $this->connection);
   }
};

/* Create database connection */
$database = new MySQLDB;

?>
