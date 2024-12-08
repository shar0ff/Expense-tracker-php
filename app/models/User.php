<?php 
    class User extends Model{

        /**
        * Get all users
        * 
        * @return array List of all users
        */

        public function getAll(){
            $query = $this->db->query("SELECT * FROM User");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
        *             
        * Get a single user by their ID
        * 
        * @param int $id The ID of the user
        * @return array|null The user details or null if not found
        */

        public function getById($id){
            $query = $this->db->query("SELECT * FROM User WHERE user_id = :id");
            $query->execute(['id' => $id]);
            return $qurery->fetch(PDO::FETCH_ASSOC);
        }

        /**
        * Create a new user
        * 
        * @param array $data The user data (email, password, role)
        * @return void
        */

        public function create(){
            $query = $this->db->prepare("INSERT INTO User (email, password, role) VALUES (:email, :password, :role)");
            $query->execute([
                'email' => $data('email'),
                'password' =>password_hash($data['password'], PASSWORD_BCRYPT),
                'role' => $data['role'] ?? 'User'
            ]);
        }

        /**
        * Update an existing user by their ID
        * 
        * @param int $id The ID of the user
        * @param array $data The updated user data (email, password, role)
        * @return void
        */

        public function update($id, $data){
            $query = $this->db->prepare("UPDATE User SET email = :email, password = :password, role = :role WHERE user_id = :id");
            $query->execute([
                'id' => $id,
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'role' => $data['role']
            ]);
        }

        /**
        * Delete a user by their ID
        * 
        * @param int $id The ID of the user
        * @return void
        */

        public function delete($id){
            $query = $this->db->prepare("DELETE FROM User WHERE user_id = :id");
            $query->execute([
                'id' => $id
            ]);
        }
    }
?>