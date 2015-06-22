<?php
class Role
{
    protected $permissions;
	private $name;
    protected function __construct($name1) {
        $this->name=$name1;
		$this->permissions = array();
    }
 
    // return a role object with associated permissions
    public static function getRolePerms($role_id, $role_name) {
        $role = new Role($role_name);
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = :role_id";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":role_id" => $role_id));
 
        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }
	
	function getRoleId(){
		$query="select role_id from roles where role_name='$this->name'";
		$result=mysql_query($query);
		$result_array=mysql_fetch_assoc($result)
		if(mysql_num_rows($result) == 1){
			return $result_array['role_id'];
		}else
			return false;
	}
 
    // check if a permission is set
    public function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }
}