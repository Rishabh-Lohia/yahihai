<?php

require_once 'DB.class.php';

class PrivilegedUser extends User
{
    private $roles;
 
    public function __construct() {
        parent::__construct();
    }
 
    // override User method
    public static function getByUsername($username) {
        $db = new DB();
		$result = mysql_query("SELECT * FROM users WHERE username = '$username'");
		
        if (!empty($result)) {
            $privUser = new PrivilegedUser(mysql_fetch_assoc($result));
            return $privUser;
        } else {
            return false;
        }
    }
 
    // populate roles with their associated permissions
    protected function initRoles() {
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":user_id" => $this->user_id));
 
        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        }
    }
 
    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}