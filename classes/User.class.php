<?php
//User.class.php
require_once 'DB.class.php';
 
 
class User {
 
    public $id;
    public $username;
    public $password;
	public $user_role;
 //   public $email;
 //   public $joinDate;
 
    //Constructor is called whenever a new object is created.
    //Takes an associative array with the DB row as an argument.
    function __construct($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : "";
        $this->username = (isset($data['username'])) ? $data['username'] : "";
        $this->password = (isset($data['password'])) ? $data['password'] : "";
		$this->initRole();
		//$this->user_role = (isset($data['user_role'])) ? $data['user_role'] : "";
    //    $this->email = (isset($data['email'])) ? $data['email'] : "";
    //  $this->joinDate = (isset($data['join_date'])) ? $data['join_date'] : "";
    }
	
	
	//This function initialises user_role with Role object with its permissions
	
	protected function initRole(){
		$query="select u.user_role as role_id, r.role_name from users u, roles r where id = '$this->id' and u.user_role=r.role_id";
		$result = mysql_query($query);
		$result_array=mysql_fetch_assoc($result);
		if(mysql_num_rows($result)==1){
			$this->user_role = Role::getRolePerms($result_array['role_id'],$result_array['role_name']);
		}else
			return false;
	}
	
	public function hasPrivilege($perm) {

		if ($this->user_role->hasPerm($perm)) {
			return true;
		}else
			return false;
    }
	
	
	
	
	
	public static function getByUsername($username){
		$db = new DB();
		$result = mysql_query("SELECT * FROM users WHERE username = '$username'");
		if(mysql_num_rows($result) == 1){
			$user = new User(mysql_fetch_assoc($result));
			return $user;
		}else
			return false;
	}
	
	
    public function save($isNewUser = false) {
        //create a new database object.
        $db = new DB();
        
        //if the user is already registered and we're
        //just updating their info.
        if(!$isNewUser) {
            //set the data array
            $data = array(
                "username" => "'$this->username'",
                "password" => "'$this->password'",
				"user_role" => "'$this->user_role->getRoleId()'"
				);
            
            //update the row in the database
            $db->update($data, 'users', 'id = '.$this->id);
        }else {
        //if the user is being registered for the first time.
            $data = array(
                "username" => "'$this->username'",
                "password" => "'$this->password'",
				"user_role" => "'$this->user_role->getRoleId()'"
				);
            
            $this->id = $db->insert($data, 'users');
            //$this->joinDate = time();
        }
        return true;
    }
    
}

?>