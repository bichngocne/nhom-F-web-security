<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel {

    public function findUserById($id) {
        $sql = 'SELECT * FROM users WHERE id = '.$id;
        $user = $this->select($sql);

        return $user;
    }

    public function findUser($keyword) {
        $sql = 'SELECT * FROM users WHERE user_name LIKE %'.$keyword.'%'. ' OR user_email LIKE %'.$keyword.'%';
        $user = $this->select($sql);

        return $user;
    }

    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password) {
        $md5Password = md5($password);
        $sql = 'SELECT * FROM users WHERE name = "' . $userName . '" AND password = "'.$md5Password.'"';

        $user = $this->select($sql);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id) {
        $sql = 'DELETE FROM users WHERE id = '.$id;
        return $this->delete($sql);

    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateUser($input) {
        // Lấy phiên bản hiện tại của người dùng
        $currentVersion = $this->getCurrentVersion($input['id']);
    
        // Kiểm tra xem phiên bản trong dữ liệu người dùng và phiên bản trong yêu cầu người dùng có trùng khớp hay không
        if ($input['version'] === $currentVersion) {
            // Phiên bản trùng khớp, tiếp tục cập nhật
            $sql = 'UPDATE users SET 
                     name = "' . mysqli_real_escape_string(self::$_connection, htmlentities($input['name'])) .'", 
                     password="'. md5(htmlentities($input['password'])) .'",
                     version = version + 1
                    WHERE id = ' . $input['id'];
    
            $user = $this->update($sql);
    
            return $user;
        } else {
            // Phiên bản không trùng khớp, trả về thông báo hoặc xử lý theo ý của bạn
            return false;
        }
    }
    
    // Hàm lấy phiên bản của người dùng dựa trên ID
    function getCurrentVersion($userId) {
    
        // Truy vấn cơ sở dữ liệu để lấy phiên bản
        $sql = "SELECT version FROM users WHERE id = ".$userId;
        $result = $this->select($sql);
        // Kiểm tra xem truy vấn đã thành công hay không
        return $result[0]['version'];
    }
    


    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input) {
        $sql = "INSERT INTO `app_web1`.`users` (`name`, `password`) VALUES (" .
                "'" . htmlentities($input['name']) . "', '".md5(htmlentities($input['password']))."')";

        $user = $this->insert($sql);

        return $user;
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = []) {
        //Keyword
        if (!empty($params['keyword'])) {
            $sql = 'SELECT * FROM users WHERE name LIKE "%' . $params['keyword'] .'%"';

            //Keep this line to use Sql Injection
            //Don't change
            //Example keyword: abcef%";TRUNCATE banks;##
            $users = self::$_connection->multi_query($sql);

            //Get data
            $users = $this->query($sql);
        } else {
            $sql = 'SELECT * FROM users';
            $users = $this->select($sql);
        }

        return $users;
    }
}