<?php 
    class Category extends Model{

        /**
        * Get all categories for a specific user
        * 
        * @param int $userId The ID of the user
        * @return array List of categories
        */

        public function getAllByUser($userId) {
            $query = $this->db->prepare("SELECT * FROM Category WHERE user_id = :user_id");
            $query->execute(['user_id' => $userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
        * Get a single category by its ID and user
        * 
        * @param int $userId The ID of the user
        * @param int $categoryId The ID of the category
        * @return array|null The category details or null if not found
        */

        public function getById($userId, $categoryId){
            $query = $this->db->prepare("SELECT * FROM Category WHERE user_id = :user_id AND category_id = :category_id");
            $query->execute([
                'user_id' => $userId,
                'category_id' => $categoryId
            ]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        /**
        * Create a new category for a user
        * 
        * @param int $userId The ID of the user
        * @param array $data The category data
        * @return void
        */

        public function create($userId, $data){
            $query = $this->db->prepare("INSERT INTO Category (user_id, category_name, category_description, type) 
            VALUES (:user_id, :name, :description, :type)");
            $query->execute([            
                'user_id' => $userId,
                'name' => $data['category_name'],
                'description' => $data['category_description'],
                'type' => $data['type']
            ]);
        }

        /**
        * Update an existing category for a user
        * 
        * @param int $userId The ID of the user
        * @param int $categoryId The ID of the category
        * @param array $data The updated category data
        * @return void
        */

        public function update($userId, $categoryId, $data){
            $query = $this->db->prepare("UPDATE Category SET category_name = :name, category_description = :description, type = :type 
            WHERE user_id = :user_id AND category_id = :category_id");
            $query->execute([
                'user_id' => $userId,
                'category_id' => $categoryId,
                'name' => $data['category_name'],
                'description' => $data['category_description'],
                'type' => $data['type']
            ]);
        }

            
        /**
        * Delete a category by its ID for a user
        * 
        * @param int $userId The ID of the user
        * @param int $categoryId The ID of the category
        * @return void
        */

        public function delete($userId, $categoryId){
            $query = $this->db->prepare("DELETE FROM Category WHERE user_id = :user_id AND category_id = :category_id");
            $query->execute([
                'user_id' => $userId,
                'category_id' => $categoryId
            ]);
        }
    }
?>