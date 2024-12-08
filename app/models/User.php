<?php 
    class User extends Model{

        // Retrieves all users from the User table.
        // Converts the query result into an array of associative arrays (array of all users), 
        // where each array represents a row with column names as keys.

        public function getAll(){
            $query = $this->db->query("SELECT * FROM User");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        // Retrieves the first (and the only one) matching row as an associative array.
        // An associative array containing the user's data or false if no user is found.

        public function getById($id){
            $query = $this->db->query("SELECT * FROM User WHERE user_id = :id");
            $query->execute(['id' => $id]);
            return $qurery->fetch(PDO::FETCH_ASSOC);
        }

        // Returns nothing explicitly, but the user is added to the database.
        // Hashes the password securely using bcrypt before storing it in the database.
        // The role is set to 'User' by default if not provided.

        public function create(){
            $query = $this->db->prepare("INSERT INTO User (email, password, role) VALUES (:email, :password, :role)");
            $query->execute([
                'email' => $data('email'),
                'password' =>password_hash($data['password'], PASSWORD_BCRYPT),
                'role' => $data['role'] ?? 'User'
            ]);
        }

        // Returns nothing explicitly, but the user's details are updated in the database.

        public function update($id, $data){
            $query = $this->db->prepare("UPDATE User SET email = :email, password = :password, role = :role WHERE user_id = :id");
            $query->execute([
                'id' => $id,
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'role' => $data['role']
            ]);
        }

        // Returns nothing explicitly, but the user is removed from the database.

        public function delete($id){
            $query = $this->db->prepare("DELETE FROM User WHERE user_id = :id");
            $query->execute([
                'id' => $id
            ]);
        }
    }
?>